<?php

namespace Ntcm\Ntm;

use Exception;
use Ntcm\Enums\HostEnum;
use Ntcm\Enums\ScanEnum;
use Ntcm\Exceptions\ScanNotFoundException;
use Ntcm\Ntm\Model\Address;
use Ntcm\Ntm\Model\Hop;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Model\Hostname;
use Ntcm\Ntm\Model\Port;
use Ntcm\Ntm\Model\Scan;
use Ntcm\Ntm\Util\ProcessExecutor;
use Carbon\Carbon;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Ntm {

    use NtmParameters, ProcessParameters;

    /**
     * This class is responsible for executing a single command process.
     *
     * @var ProcessExecutor
     */
    protected $executor;

    /**
     * Unique scan code.
     *
     * @var string
     */
    protected $scanCode;

    /**
     * @var array
     */
    protected $ports;

    /**
     * @return Ntm
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Create instance of class
     */
    public function __construct()
    {
        // set default timeout...
        $this->timeout = config('ntm.scan.timeout');

        // get last scan id...
        try {
            $this->setScanCode(intval(Scan::last()->id));
        } catch(Exception $e) {
            $this->setScanCode(0);
        }

        $this->executor = new ProcessExecutor();
    }

    /**
     * Starts new scan with input targets and ports.
     *
     * @param array | string $targets
     * @param array          $ports
     *
     * @return $this
     */
    public function scan($targets, array $ports = [])
    {
        $this->ports = $ports;

        // for non-array targets...
        if(is_string($targets)) {
            $targets = [$targets];
        }

        $targets = implode(' ', array_map(function ($target) {
            return escapeshellarg($target);
        }, $targets));

        // create a new scan...
        $scan = Scan::create([
            'id' => $this->getScanCode() + 1,
            'start' => Carbon::now()->timestamp
        ]);

        // update the current scan code...
        $this->setScanCode($scan->id);

        // check if scan directory exists...
        if( ! file_exists($this->getOutputDirectory())) {
            mkdir($this->getOutputDirectory());
        }

        // build the scan command...
        $command = sprintf('%s %s %s %s',
            $this->getExecutable(),
            implode(' ', $this->getParameters()),
            escapeshellarg($this->getOutputFile()),
            $targets
        );

        try {
            // run the scan...
            $this->executor->execute($command, $this->getTimeout());
        } catch(Exception $e) {
            // scan is failed...
            $scan->update([
                'state' => ScanEnum::FATAL
            ]);
        }

        // continue chaining...
        return $this;
    }

    /**
     * Parses the latest scanned and persists it into the database.
     *
     * @throws ScanNotFoundException when no scan found.
     */
    public function parseOutputFile()
    {
        // check if any scan found...
        if( ! $scan = Scan::find($this->getScanCode())) {
            throw new ScanNotFoundException();
        }

        // parse xml file into xml object variable...
        $xml = simplexml_load_file(
            $this->getOutputFile()
        );

        foreach($xml->host ? : [] as $xmlHost) {
            $mainAddress = (string)array_first($xmlHost->address)->attributes()->addr;

            // parse and persist hosts...
            $host = Host::findOrCreate([
                'address' => $mainAddress,
                'state'   => (string)$xmlHost->status->attributes()->state == "up" ? HostEnum::STATE_UP : HostEnum::STATE_DOWN,
                'start'   => (integer)$xmlHost->attributes()->starttime,
                'end'     => (integer)$xmlHost->attributes()->endtime,
                'scan_id' => $scan->id
            ]);

            // parse and persist addresses...
            foreach($xmlHost->address ? : [] as $xmlAddress) {
                Address::findOrCreate([
                    'address' => (string)$xmlAddress->attributes()->addr,
                    'type'    => (string)$xmlAddress->attributes()->addrtype,
                    'vendor'  => (string)$xmlAddress->attributes()->vendor,
                    'host_id' => $host->id,
                ]);
            }

            // parse and persist host names...
            foreach($xmlHost->hostnames->hostname ? : [] as $xmlHostname) {
                Hostname::findOrCreate([
                    'name'    => (string)$xmlHostname->attributes()->name,
                    'type'    => (string)$xmlHostname->attributes()->type,
                    'host_id' => $host->id,
                ]);
            }

            // parse and persist ports...
            foreach($xmlHost->ports->port ? : [] as $xmlPort) {
                Port::findOrCreate([
                    'protocol' => (string)$xmlPort->attributes()->protocol,
                    'port_id'  => (integer)$xmlPort->attributes()->portid,
                    'state'    => (string)$xmlPort->state->attributes()->state,
                    'reason'   => (string)$xmlPort->state->attributes()->reason,
                    'service'  => (string)$xmlPort->service->attributes()->name,
                    'method'   => (string)$xmlPort->service->attributes()->method,
                    'conf'     => (string)$xmlPort->service->attributes()->conf,
                    'host_id'  => $host->id,
                ]);
            }

            // initiate the first address...
            $firstAddress = $host->address;

            // parse and persist hops...
            foreach($xmlHost->trace->hop ? : [] as $xmlHop) {
                $secondAddress = (string)$xmlHop->attributes()->ipaddr;

                // find or create hosts...
                $first = Host::findOrCreate([
                    'address' => $firstAddress,
                    'scan_id' => $scan->id
                ]);
                $second = Host::findOrCreate([
                    'address' => $secondAddress,
                    'scan_id' => $scan->id
                ]);

                // don't care the loopback...
                if($firstAddress != $secondAddress) {
                    // find or create hop...
                    Hop::findOrCreate([
                        'address_first'  => $first->id,
                        'address_second' => $second->id,
                        'scan_id'        => $scan->id,
                        'rtt'            => (float)$xmlHop->rtt,
                    ]);
                }

                // shift addresses...
                $firstAddress = $secondAddress;

            }

            // update scan info...
            $scan->update([
                'total_discovered' => $xml->runstats->hosts->attributes()->up,
                'start'            => $xml->attributes()->start,
                'end'              => $xml->runstats->finished->attributes()->time,
                'state'            => ScanEnum::DONE
            ]);

        }
    }

    /**
     * @return integer
     */
    public function getScanCode()
    {
        return $this->scanCode;
    }

    /**
     * @param integer $scanCode
     */
    public function setScanCode($scanCode)
    {
        $this->scanCode = $scanCode;
    }

}
