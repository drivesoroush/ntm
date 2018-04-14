<?php

namespace Ntcm\Ntm\Commands;

use Illuminate\Console\Command;
use Ntcm\Exceptions\UnprocessableTrapException;
use Ntcm\Ncm\Model\Trap;

class TrapHandlerCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trap:handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles snmp traps.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws UnprocessableTrapException
     */
    public function handle()
    {
        $content = "";
        $address = null;

        // parse the trap...
        while($line = fgets(STDIN)) {
            $content .= $line;
        }

        // extract all ip addresses inside trap content...
        preg_match_all("/[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*/", $content, $ipAddresses);

        foreach($ipAddresses[0] as $ip) {
            // it must be a valid ip address...
            if( ! is_ip($ip)) {
                continue;
            }

            // we need ip addresses other than scanner ip address...
            if($ip == get_scanner_address()) {
                continue;
            }

            // fetch the ip address...
            $address = $ip;
        }

        // no ip addresses found...
        if( ! $address) {
            throw new UnprocessableTrapException();
        }

        // create a trap object and store it...
        $trap = Trap::create([
            'address' => $address,
            'body'    => $content
        ]);
    }
}
