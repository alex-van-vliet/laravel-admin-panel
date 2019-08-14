<?php

namespace AlexVanVliet\LAP\Fields;

trait HasType
{
    protected $type_ = null;

    public function type()
    {
        return $this->type_;
    }
}
