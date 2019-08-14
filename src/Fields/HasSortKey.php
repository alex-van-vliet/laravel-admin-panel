<?php

namespace AlexVanVliet\LAP\Fields;


trait HasSortKey
{
    protected $sort_key_ = null;

    public function sortKey($key = null)
    {
        if (is_null($key)) {
            return $this->sort_key_ ?? $this->name_;
        }

        $this->sort_key_ = $key;
        return $this;
    }

    public function unsortable()
    {
        $this->sort_key_ = false;
        return $this;
    }
}
