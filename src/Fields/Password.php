<?php

namespace AlexVanVliet\LAP\Fields;

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
}
