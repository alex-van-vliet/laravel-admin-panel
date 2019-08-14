<?php

namespace AlexVanVliet\LAP;

class Pages
{
    public const INDEX = 1 << 0;
    public const SHOW = 1 << 1;
    public const CREATE = 1 << 2;
    public const EDIT = 1 << 3;
    public const DELETE = 1 << 4;

    public const NONE = 0;
    public const ALL
        = self::INDEX | self::SHOW | self::CREATE | self::EDIT | self::DELETE;
}
