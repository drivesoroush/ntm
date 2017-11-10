<?php

return [
    // you can determine your table names...
    'tables' => [
        'hosts'           => 'hosts',
        'addresses'       => 'addresses',
        'host_names'      => 'host_names',
        'ports'           => 'ports',
        'scans'           => 'scans',
        'hops'            => 'hops',
        'os'              => 'os',
        'ssh_credentials' => 'ssh_credentials',
        'host_groups'     => 'host_groups',
    ],

    'scan' => [
        // you can determine scan process execution timeout default value in seconds...
        'timeout' => 24 * 60 * 60,
    ]
];