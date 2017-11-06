<?php

return [
    // you can determine your table names...
    'tables' => [
        'hosts'      => 'hosts',
        'addresses'  => 'addresses',
        'host_names' => 'host_names',
        'ports'      => 'ports',
        'scans'      => 'scans',
        'hops'       => 'hops',
        'os'         => 'os',
    ],

    'scan' => [
        // you can determine scan process execution timeout default value in seconds...
        'timeout'   => 60,

        // you can determine scan frequency in seconds here...
        'frequency' => 2 * 60 * 60
    ]
];