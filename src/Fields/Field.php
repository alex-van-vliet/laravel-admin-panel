<?php

namespace AlexVanVliet\LAP\Fields;

interface Field
{
    public const INLINE = 0;
    public const BLOCK = 1;

    public function pages($pages = null);

    public function displayText($name = null);

    public function sortable($key = null);
    public function unsortable();

    public function view($type);
}
