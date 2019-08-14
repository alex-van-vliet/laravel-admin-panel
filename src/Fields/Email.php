<?php

namespace AlexVanVliet\LAP\Fields;

class Email extends DataField
{
    public function __construct($name)
    {
        parent::__construct('email', $name);
    }
}
