<?php

namespace AlexVanVliet\LAP\Fields;

use Illuminate\Support\Facades\Hash;

class Password extends DataField
{
    public function __construct($name)
    {
        parent::__construct('password', $name);
    }

    public function view($type)
    {
        return "lap::fields.password.$type";
    }

    public function storeValue($value)
    {
        return Hash::make($value);
    }

    public function updateValue($current, $value)
    {
        if (is_null($value))
            return $current;
        return Hash::make($value);
    }

    public function removeFromInputIfEmptyOnUpdate()
    {
        return true;
    }
}
