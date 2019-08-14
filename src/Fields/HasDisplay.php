<?php

namespace AlexVanVliet\LAP\Fields;

trait HasDisplay
{
    protected $display_ = Field::INLINE;

    public function display()
    {
        return $this->display_;
    }

    public function inline()
    {
        $this->display_ = Field::INLINE;
        return $this;
    }

    public function block()
    {
        $this->display_ = Field::BLOCK;
        return $this;
    }

    public function hidden()
    {
        $this->display_ = Field::HIDDEN;
        return $this;
    }
}
