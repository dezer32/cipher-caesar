<?php

namespace Dezer32\Cipher\Caesar;

use Dezer32\Cipher\Caesar\Enum\Language;

class RuCaesarCipher extends AbstractLanguageCaesarCipher
{
    private const ABC = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя';

    public function getAbc(): string
    {
        return self::ABC;
    }

    public function getLanguage(): Language
    {
        return Language::RU;
    }
}
