<?php

namespace Dezer32\Cipher\Caesar\Contracts;

use Dezer32\Cipher\Caesar\Enum\Language;

interface LanguageCaesarCipherInterface
{
    public function encode(string $string, int $key): string;

    public function decode(string $string, int $key): string;

    public function getAbc(): string;

    public function getLanguage(): Language;
}
