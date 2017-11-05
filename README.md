# Network Topology Mapper

Network topology mapper with Laravel 5.


First of all you must add provider into your `app.php` config file.

```php
    'providers' => [
        ...
        Ntcm\Ntm\NtmServiceProvider::class
        ...
    ]
```

Now you must publish config files.
```
$ php artisan vendor:publish
```

Now do the migration.
```
$ php artisan migrate
```
