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

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel 5.5+:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Tugumuda\Helpers\HelpersServiceProvider::class,
```

If you want to use the facade, add this to your facades in app.php:

```php
'BSForm' => Tugumuda\Helpers\BSFormFacade::class,
'TMFormatter' => Tugumuda\Helpers\FormatterFacade::class,
'TMConverter' => Tugumuda\Helpers\ConverterFacade::class,
```
