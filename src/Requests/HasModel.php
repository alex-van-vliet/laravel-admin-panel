<?php

namespace AlexVanVliet\LAP\Requests;

trait HasModel
{
    /**
     * @var string
     */
    protected $model = [];

    /**
     * @var array
     */
    protected $fields = [];

    public function setupModel($model, $fields)
    {
        $this->model = $model;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
