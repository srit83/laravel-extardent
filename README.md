#Extsentry

an extension package for laravelbook/ardent

##Install

Add `srit83/laravel-extardent` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "srit83/laravel-extardent": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

Add the service provider to your `app/config/app.php`

```php
'providers' => array(
    //...
    'Srit83\Extsentry\ExtsentryServiceProvider',
    //...
)
```

Thats it. ;-)

##Using

Extend your models from `Extardent` class

```php
<?php
use Srit83\LaravelExtardent\Extardent;

class SmsRecipient extends Extardent
{
}

```

If you dont know how you configure your rules or before and after events show <[https://github.com/laravelbook/ardent](Max Ehsans laravelbook/ardent package on github)>

Have coding fun! ;-)