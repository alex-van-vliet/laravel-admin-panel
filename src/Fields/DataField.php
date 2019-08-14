<?php

namespace AlexVanVliet\LAP\Fields;

abstract class DataField implements Field
{
    use HasSortKey;
    use HasPages;
    use HasDisplayText;
    use HasType;
    use HasName;

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
}
