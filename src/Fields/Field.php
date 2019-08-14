<?php

namespace AlexVanVliet\LAP\Fields;

interface Field
{
    public const HIDDEN = 0;
    public const INLINE = 1;
    public const BLOCK = 2;

    public function display();
    public function inline();
    public function block();
    public function hidden();

    public function displayText($name = null);

    public function sortable($key = null);
    public function unsortable();

    public function view($type);
}
