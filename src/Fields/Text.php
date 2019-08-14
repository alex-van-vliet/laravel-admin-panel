<?php

namespace AlexVanVliet\LAP\Fields;

class Text extends DataField
{
    public function __construct($name)
    {
        parent::__construct('text', $name);
    }
}
