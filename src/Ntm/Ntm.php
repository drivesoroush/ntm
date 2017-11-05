<?php

namespace Ntcm\Ntm;

use Exception;
use Ntcm\Exceptions\ScanNotFoundException;
use Ntcm\Ntm\Model\Address;
use Ntcm\Ntm\Model\Hop;
use Ntcm\Ntm\Model\Host;
use Ntcm\Ntm\Model\Hostname;
use Ntcm\Ntm\Model\Port;
use Ntcm\Ntm\Model\Scan;
use Ntcm\Ntm\Util\ProcessExecutor;

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
        ]);

        // update the current scan code...
        $this->setScanCode($scan->id);

        // build the scan command...
        $command = sprintf('%s %s %s %s',
            $this->getExecutable(),
            implode(' ', $this->getParameters()),
            escapeshellarg($this->getOutputFile()),
            $targets
        );

        // run the scan...
        $this->executor->execute($command, $this->getTimeout());

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

        foreach($xml->host as $xmlHost) {
            // parse and persist hosts...
            $host = Host::create([
                'state'   => (string)$xmlHost->status->attributes()->state,
                'start'   => (integer)$xmlHost->attributes()->starttime,
                'end'     => (integer)$xmlHost->attributes()->endtime,
                'scan_id' => $scan->id
            ]);

            // parse and persist addresses...
            foreach($xmlHost->address as $xmlAddress) {
                Address::create([
                    'address' => (string)$xmlAddress->attributes()->addr,
                    'type'    => (string)$xmlAddress->attributes()->addrtype,
                    'vendor'  => (string)$xmlAddress->attributes()->vendor,
                    'host_id' => $host->id,
                ]);
            }

            // parse and persist host names...
            foreach($xmlHost->hostnames->hostname as $xmlHostname) {
                Hostname::create([
                    'name'    => (string)$xmlHostname->attributes()->name,
                    'type'    => (string)$xmlHostname->attributes()->type,
                    'host_id' => $host->id,
                ]);
            }

            // parse and persist ports...
            foreach($xmlHost->ports->port as $xmlPort) {
                Port::create([
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

            // parse and persist hops...
            foreach($xmlHost->trace->hop as $xmlHop) {
                $rtt = (float)$xmlHop->rtt;
                $first = $host->address;
                $second = (string)$xmlHop->attributes()->ipaddr;
                
                if( ! $hop = Hop::exists($first, $second)) {
                    Hop::create([
                        'address_first'  => $first,
                        'address_second' => $second,
                        'scan_id'        => $scan->id,
                        'rtt'            => $rtt,
                    ]);
                } else {
                    $hop->update(['rtt' => $rtt]);
                }
            }

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
