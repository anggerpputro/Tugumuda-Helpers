# Laravel Tugumuda Helpers

[![License](https://poser.pugx.org/tugumuda/helpers/license)](https://packagist.org/packages/tugumuda/helpers)
[![Total Downloads](https://poser.pugx.org/tugumuda/helpers/downloads)](https://packagist.org/packages/tugumuda/helpers)
[![Latest Stable Version](https://poser.pugx.org/tugumuda/helpers/v/stable)](https://packagist.org/packages/tugumuda/helpers)
[![Latest Unstable Version](https://poser.pugx.org/tugumuda/helpers/v/unstable)](https://packagist.org/packages/tugumuda/helpers)

## Installation
Require this package with composer.

```shell
composer require tugumuda/helpers
```

### Laravel 5.1+:

```php
Collective\Html\HtmlServiceProvider::class,
Tugumuda\Helpers\ServiceProvider::class,
```

If you want to use the facade, add this to your facades in app.php:

```php
'BSForm' => Tugumuda\Helpers\Facades\BSFormFacade::class,
'TMFormatter' => Tugumuda\Helpers\Facades\FormatterFacade::class,
'TMConverter' => Tugumuda\Helpers\Facades\ConverterFacade::class,
```

## Usage

You can now add messages using the Facade (when added):

### BSForm
```php
BSForm::label('fullname', 'Fullname:');
BSForm::text('fullname', 'Angger Priyardhan Putro');

BSForm::textGroup('fullname', 'Fullname:', 'Angger Priyardhan Putro');
```

### Converter
```php
TMConverter::int2money('100000');
TMConverter::array2object(['name' => 'Angger', 'email' => 'anggerpputro@gmail.com']);
```
