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
    protected $signature = 'scan {ranges* : List of hosts or networks to scan separated by space.}
                                 {--s|scheduled= : Determine if the scan is scheduled.}
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
        $ranges = $this->argument('ranges');
        $scanPorts = $this->option('ports');
        $scanOs = $this->option('os');
        $scheduled = $this->option('scheduled');

        // initiate the scan job...
        CreateScanJob::dispatch(
            $ranges,
            $scanPorts,
            $scanOs,
            $scheduled
        );

    }
}
