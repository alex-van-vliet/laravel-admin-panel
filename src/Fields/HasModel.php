<?php

namespace AlexVanVliet\LAP\Fields;

use AlexVanVliet\LAP\Exceptions\SetupException;

trait HasModel
{
    protected $model_ = null;

    public function setupModel()
    {
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $call) {
            if ($call['function'] === 'getConfig') {
                $this->model_ = $call['class'];
                break;
            }
        }
        if (is_null($this->model_))
            throw new SetupException('Field not instantiated in getConfig.');
    }

    public function model($model = null)
    {
        if (is_null($model)) {
            return $this->model_;
        }
        $this->model_ = $model;
        return $this;
    }
}
