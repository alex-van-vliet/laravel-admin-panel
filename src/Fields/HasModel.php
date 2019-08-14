<?php

namespace AlexVanVliet\LAP\Fields;

trait HasModel
{
    protected $model_ = null;

    public function model($model = null)
    {
        if (is_null($model))
            return $this->model_;
        $this->model_ = $model;
        return $this;
    }
}
