<?php

namespace Ntcm\Ntm\Commands;

use Illuminate\Console\Command;
use Ntcm\Ntm\Jobs\CreateScanJob;
use Ntcm\Ntm\Model\Target;

class ScanCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan {ranges* : List of hosts or networks to scan separated by space.}
                                 {--s|scheduled= : Determine scheduled target to scan. Just pass cron string here but we won\' run the scan when you do.}
                                 {--o|os : Enable operating system scan.}
                                 {--p|ports : Enable well-known port scanning.}
                                 {--u|user= : Id of user who created this scan.}
                                 ';

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
        $user = $this->option('user');

        // if user passes the scheduled cron string then just store the target...
        if( ! is_null($scheduled)) {
            Target::create([
                'ranges'    => $ranges,
                'ports'     => $scanPorts,
                'os'        => $scanOs,
                'scheduled' => $scheduled,
                'user_id'   => $user
            ]);
        } else {
            // initiate the scan job...
            CreateScanJob::dispatch(
                $ranges,
                $user,
                $scanPorts,
                $scanOs
            );
        }
    }
}
