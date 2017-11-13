<?php

namespace Ntcm\Ntm\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ntcm\Enums\ScanEnum;
use Ntcm\Ntm\Model\Scan;
use Ntcm\Ntm\Ntm;

class CreateScanJob implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var integer
     */
    public $timeout;

    /**
     * @var string
     */
    protected $range;

    /**
     * @var boolean
     */
    protected $scanPorts;

    /**
     * @var boolean
     */
    protected $scanOs;

    /**
     * Create a new job instance.
     *
     * @param string | array $range
     * @param boolean        $scanPorts
     * @param boolean        $scanOs
     * @param integer        $timeout
     */
    public function __construct($range, $scanPorts = true, $scanOs = true, $timeout = null)
    {
        if(is_array($range)) {
            $this->range = $range;
        } else {
            $this->range = explode(' ', str_replace(',', ' ', $range));
        }
        $this->scanPorts = $scanPorts;
        $this->scanOs = $scanOs;

        // set the timeout...
        if(is_null($timeout)) {
            $this->timeout = config('ntm.scan.timeout');
        } else {
            $this->timeout = $timeout;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // do the scan here...
        $scan = Ntm::create()
                   ->setTimeout($this->timeout)
                   ->setPortScan($this->scanPorts)
                   ->setOsDetection($this->scanOs)
                   ->scan($this->range)
                   ->parseOutputFile();
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        Scan::last()->update(['status' => ScanEnum::FATAL]);
    }
}
