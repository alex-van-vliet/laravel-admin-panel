<?php

namespace AlexVanVliet\LAP\Fields;

abstract class DataField implements Field
{
    use HasModel, HasSortKey, HasPages, HasDisplayText, HasType, HasName,
        HasRules;

    public function __construct($type, $name)
    {
        $this->type_ = $type;
        $this->name_ = $name;
    }

    public function view($type)
    {
        return "lap::fields.default.$type";
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

    public function renameBeforeSave()
    {
        return null;
    }

    public function removeFromInputIfEmptyOnStore()
    {
        return false;
    }

    public function removeFromInputIfEmptyOnUpdate()
    {
        return false;
    }
}
