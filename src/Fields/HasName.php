<?php

namespace AlexVanVliet\LAP\Fields;

trait HasName
{
    protected $name_ = null;

    public function name()
    {
        return $this->name_;
    }
}
