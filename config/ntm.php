<?php

return [
    // you can determine your table names...
    'tables' => [
        'hosts'            => 'hosts',
        'addresses'        => 'addresses',
        'host_names'       => 'host_names',
        'ports'            => 'ports',
        'scans'            => 'scans',
        'hops'             => 'hops',
        'os'               => 'os',
        'ssh_credentials'  => 'ssh_credentials',
        'groups'           => 'groups',
        'host_group'       => 'host_group',
        'targets'          => 'targets',
        'snmp_credentials' => 'snmp_credentials',
        'mib'              => 'mib',
        'host_groups'      => 'host_groups',
        'host_scan'        => 'host_scan',
    ],

    'scan'      => [
        // you can determine scan process execution timeout default value in seconds...
        'timeout' => 24 * 60 * 60,

        // well-known ports...
        'ports'   => '1-1000',
    ],

    // remotable operating systems...
    'remotable' => [
        'Linux',
        'VxWorks',
        'embedded',
        'NonStop OS',
        'ESXi',
        'FreeBSD',
        'ESX Server',
        //'Windows',
        //'Android',
        'OpenBSD',
        'RouterOS',
        'Fireware',
    ],
];