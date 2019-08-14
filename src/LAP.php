<?php

namespace AlexVanVliet\LAP;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

class LAP extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'lap';
    }
}
