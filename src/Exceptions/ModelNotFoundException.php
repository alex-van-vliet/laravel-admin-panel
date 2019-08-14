<?php

namespace AlexVanVliet\LAP\Exceptions;


class ModelNotFoundException extends Exception
{
    public function render()
    {
        return abort(404);
    }
}
