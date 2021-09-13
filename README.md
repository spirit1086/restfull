# Laravel RESTfull (auth Bearer)
[![Latest Version on Github](https://img.shields.io/github/v/release/spirit1086/restfull.svg?style=flat)](https://packagist.org/packages/spirit1086/restfull)
![](https://github.com/spirit1086/restfull/workflows/PHP%20Composer/badge.svg?branch=main)
[![Total Downloads](https://img.shields.io/packagist/dt/spirit1086/restfull.svg?style=flat)](https://packagist.org/packages/spirit1086/restfull)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/spirit1086/restfull.svg?style=flat)](https://img.shields.io/packagist/v/spirit1086/restfull.svg)
# Installation

Install the package through [Composer](https://getcomposer.org)

Run the Composer require command from the Terminal:
```php
composer require spirit1086/restfull
```

Open your config/app.php and add a new line to the providers array.
```php
\Spirit1086\Restfull\Modules\ModulesServiceProvider::class
```

Open your app/Http/Kernel.php add this middleware
```php
protected $middlewareGroups = [
 'api' => [
     ...
     \Spirit1086\Restfull\Middleware\JsonMiddleware::class
    ],
 ]       
protected $routeMiddleware = [
  ...
  'token.expires'=>\Spirit1086\Restfull\Middleware\CheckTokenExpires::class
];
```
# Exceptions
Open your app/Exceptions/Handler.php and change (**render,apiResponse** methods) like  Exceptions/Handler.php on this package
# Authentication provider
Open your config/auth.php and put this code:
```php
'providers' => [
        'api_users' => [
            'driver' => 'eloquent',
            'model' => \Spirit1086\Restfull\Modules\Auth\Models\User::class,
        ]
    ],
```

And change api provider:
```php
'guards' => [
        'api' => [
            'driver' => 'token',
            'provider' => 'api_users',
            'hash' => false,
        ],
    ]
```

# Artisan commands
On root project execute commands
```php
php artisan migrate
php artisan db:seed --class="Spirit1086\Restfull\Modules\Auth\Seed\UserSeeder"
```

Now you're ready to start using the RESTfull with Bearer auth in your application.

# License
The MIT License (MIT). Please see [License File](https://en.wikipedia.org/wiki/MIT_License) for more information.
