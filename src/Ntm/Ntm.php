<?php

namespace Ntcm\Ntm;

use Exception;
use Ntcm\Exceptions\ScanNotFoundException;
use Ntcm\Ntm\Model\Address;
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
            $this->setScanCode(Scan::last()->id);
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

        // for non-array inputs...
        if(is_string($targets)) {
            $targets = [$targets];
        }

        $targets = implode(' ', array_map(function ($target) {
            return escapeshellarg($target);
        }, $targets));

        $command = sprintf('%s %s %s %s',
            $this->getExecutable(),
            implode(' ', $this->getParameters()),
            escapeshellarg($this->getOutputFile()),
            $targets
        );

        $this->executor->execute($command, $this->getTimeout());

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
        if($this->getScanCode() === 0) {
            throw new ScanNotFoundException();
        }

        // parse xml file into xml object variable...
        $xml = simplexml_load_file(
            $this->getOutputFile()
        );

        // find or create a new scan...
        if( ! $scan = Scan::find($this->getScanCode())) {
            $scan = Scan::create([
                'id'               => $this->getScanCode(),
                'total_discovered' => $xml->runstats->hosts->attributes()->up,
                'start'            => $xml->attributes()->start,
                'end'              => $xml->runstats->finished->attributes()->time,
            ]);
        }

        foreach($xml->host as $xmlHost) {
            $host = Host::create([
                'state'   => (string)$xmlHost->status->attributes()->state,
                'start'   => (integer)$xmlHost->attributes()->starttime,
                'end'     => (integer)$xmlHost->attributes()->endtime,
                'scan_id' => $scan->id
            ]);

            foreach($xmlHost->address as $xmlAddress) {
                Address::create([
                    'address' => (string)$xmlAddress->attributes()->addr,
                    'type'    => (string)$xmlAddress->attributes()->addrtype,
                    'vendor'  => (string)$xmlAddress->attributes()->vendor,
                    'host_id' => $host->id,
                ]);
            }

            foreach($xmlHost->hostnames->hostname as $xmlHostname) {
                Hostname::create([
                    'name'    => (string)$xmlHostname->attributes()->name,
                    'type'    => (string)$xmlHostname->attributes()->type,
                    'host_id' => $host->id,
                ]);
            }

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

        }
    }

    /**
     * @return string
     */
    public function getScanCode()
    {
        return $this->scanCode;
    }

    /**
     * @param string $scanCode
     */
    public function setScanCode($scanCode)
    {
        $this->scanCode = $scanCode;
    }

}
