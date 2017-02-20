# Laravel Importer

[![Latest Stable Version](https://poser.pugx.org/luna/laravel-importer/v/stable)](https://packagist.org/packages/luna/laravel-importer")
[![Total Downloads](https://poser.pugx.org/luna/laravel-importer/downloads)](https://packagist.org/packages/luna/laravel-importer)
[![Latest Unstable Version](https://poser.pugx.org/luna/laravel-importer/v/unstable)](https://packagist.org/packages/luna/laravel-importer)
[![StyleCI](https://styleci.io/repos/82349568/shield?branch=master)](https://styleci.io/repos/82349568)
[![TravisCI](https://travis-ci.org/DuckThom/laravel-importer.svg?branch=master)](https://travis-ci.org/DuckThom/laravel-importer)
[![License](https://poser.pugx.org/luna/laravel-importer/license)](https://packagist.org/packages/luna/laravel-importer)

## Prerequisites

- PHP 7.0 or 7.1
- Laravel 5.4

## Installation

To install this package, run:
```
composer require luna/laravel-importer 
```

## Setup

Add the service provider and facade to `config/app.php`:
```php
    'providers' => [
        // ...
        // Package providers
        
        Luna\Importer\ServiceProvider::class,
    ],
     
    'aliases' => [
        // ...
        
        "Import" => Luna\Importer\ImporterFacade::class
    ]
```

Publish the configuration:
```
    php artisan vendor:publish --provider="Luna\Importer\ServiceProvider"
```

## Contributing

1. Fork `https://github.com/DuckThom/laravel-importer`
2. Run `composer install`
3. Make changes
4. Add tests if possible
5. Push and create a PR