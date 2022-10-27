<?php

namespace Dezer32\Cipher\Caesar\Contracts;

use Dezer32\Cipher\Caesar\Exceptions\UnexpectedSymbolCaesarException;

interface LanguageCaesarCipherInterface
{
    public function encode(string $string, int $key): string;

    public function decode(string $string, int $key): string;
}
