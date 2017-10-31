<?php

namespace Ntm;

use Ntm\Model\Address;
use Ntm\Model\Host;
use Ntm\Model\Hostname;
use Ntm\Model\Port;
use Ntm\Model\Scan;

/**
 * @author Soroush Kazemi <kazemi.soroush@gmail.com>
 */
class Ntm {

    protected $osDetection = true;

    protected $serviceInfo = true;

    protected $verbose = true;

    protected $treatHostsAsOnline = true;

    protected $portScan = true;

    protected $reverseDns = true;

    protected $executable = "nmap";

    protected $outputFile = "/output.xml";

    protected $executor;

    /**
     * @return Ntm
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Starts new scan with input targets and ports.
     *
     * @param array $targets
     * @param array $ports
     */
    public function scan(array $targets, array $ports = [])
    {
        $targets = implode(' ', array_map(function ($target) {
            return escapeshellarg($target);
        }, $targets));

        $options = [];
        if($this->osDetection) {
            $options[] = '-O';
        }

        if($this->serviceInfo) {
            $options[] = '-sV';
        }

        if($this->verbose) {
            $options[] = '-v';
        }

        if($this->portScan) {
            $options[] = '-sn';
        } elseif( ! empty($ports)) {
            $options[] = '-p ' . implode(',', $ports);
        }

        if($this->reverseDns) {
            $options[] = '-n';
        }

        if($this->treatHostsAsOnline) {
            $options[] = '-Pn';
        }

        $options[] = '-oX';

        $command = sprintf('%s %s %s %s',
            $this->executable,
            implode(' ', $options),
            escapeshellarg(storage_path($this->outputFile)),
            $targets
        );

        $this->executor->execute($command);

    }

    private function parseOutputFile($xmlFile)
    {
        $xml = simplexml_load_file($xmlFile);

        $scan = Scan::create([
            'total_discovered' => $xml->runstats->hosts->attributes()->up,
            'start'            => $xml->attributes()->start,
            'end'              => $xml->runstats->finished->attributes()->time,
        ]);

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

}
