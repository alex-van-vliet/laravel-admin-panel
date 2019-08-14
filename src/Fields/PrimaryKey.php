<?php

namespace AlexVanVliet\LAP\Fields;

class PrimaryKey extends DataField
{
    public function __construct($name)
    {
        parent::__construct('number', $name);
    }

    public function readonly()
    {
        return true;
    }
}
