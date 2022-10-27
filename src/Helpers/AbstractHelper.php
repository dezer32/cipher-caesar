<?php

namespace Dezer32\Cipher\Caesar\Helpers;

abstract class AbstractHelper
{
    private const instance = null;

    public static function make(): static
    {
        return self::instance ?? new static();
    }
}
