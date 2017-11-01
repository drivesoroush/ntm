# Network Topology Mapper

Network topology mapper with Laravel 5.

```
$ php artisan vendor:publish --provider=Ntcm\Ntm\NtmServiceProvider --tag=config
```

```
$ php artisan vendor:publish --provider=Ntcm\Ntm\NtmServiceProvider --tag=migrations
```

```php
    'providers' => [
        ...
        Ntcm\Ntm\NtmServiceProvider::class
        ...
    ]
```