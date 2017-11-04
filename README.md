# Network Topology Mapper

Network topology mapper with Laravel 5.

```
$ php artisan vendor:publish --provider=Ntcm\Ntm\NtmServiceProvider --tag=config
```

Add provider into your `app.php` config file.

```php
    'providers' => [
        ...
        Ntcm\Ntm\NtmServiceProvider::class
        ...
    ]
```
