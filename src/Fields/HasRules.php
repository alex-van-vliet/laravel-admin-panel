<?php

namespace AlexVanVliet\LAP\Fields;

trait HasRules
{
    protected $rules_ = null;

    public function rules($rules = null)
    {
        if ($rules === null) {
            return $this->rules_;
        }
        $this->rules_ = $rules;
        return $this;
    }
}
