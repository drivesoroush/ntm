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
        'groups'          => 'groups',
        'host_group'      => 'host_group',
    ],

    'scan' => [
        // you can determine scan process execution timeout default value in seconds...
        'timeout' => 24 * 60 * 60,
    ]
];