<?php

return [
    // proper python version...
    'python' => [
        'version' => 3.6
    ],

    // you can determine your table names...
    'tables' => [
        // ntm...
        'hosts'              => 'hosts',
        'addresses'          => 'addresses',
        'host_names'         => 'host_names',
        'ports'              => 'ports',
        'scans'              => 'scans',
        'hops'               => 'hops',
        'os_detected'        => 'os_detected',
        'os_generic'         => 'os_generic',
        'ssh_credentials'    => 'ssh_credentials',
        'groups'             => 'groups',
        'host_group'         => 'host_group',
        'targets'            => 'targets',
        // snmp
        'snmp_credentials'   => 'snmp_credentials',
        'mib'                => 'mib',
        'host_groups'        => 'host_groups',
        'host_scan'          => 'host_scan',
        'scanned'            => 'scanned',
        // ncm...
        'backups'            => 'backups',
        'traps'              => 'traps',
        'commands'           => 'commands',
        'command_os_generic' => 'command_os_generic',
    ],

    'scan'      => [
        // you can determine scan process execution timeout default value in seconds...
        'timeout'               => 24 * 60 * 60,

        // host timeout in seconds...
        'host_timeout'          => 30 * 60,

        // well-known ports...
        'ports'                 => '1-1000',
        'os_detection'          => true,
        'service_info'          => true,
        'verbose'               => false,
        'treat_hosts_as_online' => true,
        'port_Scan'             => true,
        'reverse_Dns'           => true,
        'traceroute'            => true,
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
        'IOS',
    ],
];