<?php

namespace AlexVanVliet\LAP\Fields;

class Email extends DataField
{
    public function __construct($model, $name)
    {
        parent::__construct($model, $name, 'email');
    }
}
