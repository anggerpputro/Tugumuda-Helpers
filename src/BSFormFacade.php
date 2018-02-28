<?php

namespace Tugumuda\Helpers;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tugumuda\Helpers\BootstrapFormBuilder
 */
class BSFormFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'BSForm';
    }
}
