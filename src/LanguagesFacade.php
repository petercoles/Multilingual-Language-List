<?php

namespace PeterColes\Languages;

use Illuminate\Support\Facades\Facade;

/**
 */
class LanguagesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'languages';
    }
}
