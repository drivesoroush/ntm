<?php

namespace Ntcm\Ntm\Commands;

use Illuminate\Console\Command;
use Ntcm\Ntm\Jobs\CreateScanJob;

class ScanCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan {targets* : List of target hosts or networks to scan.}
                                 {--o|os : Enable operating system scan.}
                                 {--p|ports : Enable well-known port scanning.}
                                 ';

    // {t|timeout? : Total timeout considered for this scan.}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // retrieve the arguments...
        $targets = $this->argument('targets');
        $scanPorts = $this->option('ports');
        $scanOs = $this->option('os');

        // initiate the scan job...
        CreateScanJob::dispatch(
            $targets,
            $scanPorts,
            $scanOs
        );

    }
}
