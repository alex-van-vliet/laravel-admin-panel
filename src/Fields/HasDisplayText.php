<?php

namespace AlexVanVliet\LAP\Fields;


trait HasDisplayText
{
    protected $display_text_ = null;

    public function displayText($name = null)
    {
        if (is_null($name)) {
            return $this->display_text_ ?? $this->name_;
        }

        $this->display_text_ = $name;
        return $this;
    }
}
