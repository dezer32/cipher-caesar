<?php

namespace Dezer32\Cipher\Caesar;

use Dezer32\Cipher\Caesar\Enum\Language;

class EnCaesarCipher extends AbstractLanguageCaesarCipher
{
    private const ABC = 'abcdefghijklmnopqrstuvwxyz';

    public function getAbc(): string
    {
        return self::ABC;
    }

    public function getLanguage(): Language
    {
        return Language::EN;
    }
}
