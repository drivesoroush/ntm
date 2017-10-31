<?php

namespace NtmTest;

use Ntm\Nmap;
use PHPUnit_Framework_TestCase;

class MapperTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function it_tests_hosts_list_retrieve()
    {
        Nmap::create()->scan('scanme.nmap.org');
    }
}
