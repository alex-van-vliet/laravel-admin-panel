<?php

namespace AlexVanVliet\LAP;

use Exception;
use Throwable;

class MissingOptionException extends Exception
{
    public function __construct($option)
    {
        parent::__construct("Missing option: $option.");
    }
}
