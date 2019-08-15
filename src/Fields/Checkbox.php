<?php

namespace AlexVanVliet\LAP\Fields;

use Illuminate\Support\Facades\Hash;

class Checkbox extends DataField
{
    public function __construct($name)
    {
        parent::__construct('password', $name);
    }

    public function view($type)
    {
        return "lap::fields.checkbox.$type";
    }

    public function storeValue($value)
    {
        return !!$value;
    }

    public function updateValue($current, $value)
    {
        if (is_null($value))
            return false;
        return $this->storeValue($value);
    }
}
