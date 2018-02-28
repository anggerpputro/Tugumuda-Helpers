<?php

namespace Tugumuda\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tugumuda\Helpers\Formatter
 */
class FormatterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TMFormatter';
    }
}
