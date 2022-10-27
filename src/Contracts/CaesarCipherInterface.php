<?php

namespace Dezer32\Cipher\Caesar\Contracts;

use Dezer32\Cipher\Caesar\Enum\Language;

interface CaesarCipherInterface
{
    public function encode(string $string, int $key, Language $language): string;

    public function decode(string $string, int $key, Language $language): string;

    /** @return string[] */
    public function decodeWithoutKey(string $string, Language $language): array;
}
