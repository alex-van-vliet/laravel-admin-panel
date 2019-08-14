<?php

namespace AlexVanVliet\LAP\Fields;

class BelongsTo implements Field
{
    use HasModel, HasPages, HasDisplayText, HasType, HasName, HasRules;

    public function __construct($name)
    {
        $this->name_ = $name;
    }

    public function view($type)
    {
        return "lap::fields.belongs-to.$type";
    }

    public function renameBeforeSave()
    {
        $model = $this->model();
        $instance = new $model();
        return $instance->{$this->name()}()->getForeignKeyName();
    }

    public function options()
    {
        $model = $this->model();
        $instance = new $model();
        return $instance
            ->{$this->name()}()
            ->getRelated()
            ->query()
            ->get()
            ->mapWithKeys(function ($value) {
                return [$value->id => (string) $value];
            })
            ->sort()
            ->toArray();
    }

    public function display()
    {
        return Field::INLINE;
    }

    public function readonly()
    {
        return false;
    }

    public function storeValue($value)
    {
        return $value;
    }

    public function updateValue($current, $value)
    {
        if (is_null($value)) {
            return $current;
        }
        return $value;
    }

    public function removeFromInputIfEmptyOnStore()
    {
        return false;
    }

    public function removeFromInputIfEmptyOnUpdate()
    {
        return false;
    }

    public function sortKey($key = null)
    {
        if (is_null($key)) {
            return false;
        }
        return $this;
    }

    public function unsortable()
    {
        return $this;
    }
}
