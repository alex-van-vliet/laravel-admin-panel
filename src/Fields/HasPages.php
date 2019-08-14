<?php

namespace AlexVanVliet\LAP\Fields;

use AlexVanVliet\LAP\Pages;

trait HasPages
{
    protected $pages_ = Pages::ALL;

    public function pages($pages = null)
    {
        if ($pages === null) {
            return $this->pages_;
        }
        $this->pages_ = $pages;
        return $this;
    }
}
