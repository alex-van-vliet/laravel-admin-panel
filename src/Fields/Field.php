<?php

namespace AlexVanVliet\LAP\Fields;

interface Field
{
    public const INLINE = 0;
    public const BLOCK = 1;

    public function pages($pages = null);

    public function displayText($name = null);

    public function sortKey($key = null);
    public function unsortable();

    public function view($type);

    public function readonly();

    public function rules($rules = null);

    public function renameBeforeSave();

    public function storeValue($value);
    public function updateValue($current, $value);

    public function removeFromInputIfEmptyOnStore();
    public function removeFromInputIfEmptyOnUpdate();
}
