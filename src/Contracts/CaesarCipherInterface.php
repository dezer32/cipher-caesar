<?php

namespace Dezer32\Cipher\Caesar\Contracts;

use Dezer32\Cipher\Caesar\Enum\Language;
use Dezer32\Cipher\Caesar\Exceptions\ExistLanguageCaesarException;
use Dezer32\Cipher\Caesar\Exceptions\NotFoundLanguageCaesarException;

interface CaesarCipherInterface
{
    /**
     * @throws ExistLanguageCaesarException
     */
    public function addLanguage(LanguageCaesarCipherInterface $caesarCipher): void;

    /**
     * @throws NotFoundLanguageCaesarException
     */
    public function encode(string $string, int $key, Language $language): string;

    /**
     * @throws NotFoundLanguageCaesarException
     */
    public function decode(string $string, int $key, Language $language): string;

    /**
     * @return string[]
     * @throws NotFoundLanguageCaesarException
     */
    public function decodeWithoutKey(string $string, Language $language): array;
}
