<?php

namespace Dezer32\Cipher\Caesar;

use Dezer32\Cipher\Caesar\Contracts\CaesarCipherInterface;
use Dezer32\Cipher\Caesar\Contracts\LanguageCaesarCipherInterface;
use Dezer32\Cipher\Caesar\Enum\Language;
use Dezer32\Cipher\Caesar\Exceptions\ExistLanguageCaesarException;
use Dezer32\Cipher\Caesar\Exceptions\NotFoundLanguageCaesarException;

class CaesarCipher implements CaesarCipherInterface
{
    /** @var LanguageCaesarCipherInterface[] */
    private array $languageCiphers = [];

    public function addLanguage(LanguageCaesarCipherInterface $caesarCipher): void
    {
        if (isset($this->languageCiphers[$caesarCipher->getLanguage()->name])) {
            $message = sprintf('Language "%s" exists.', $caesarCipher->getLanguage()->name);

            throw new ExistLanguageCaesarException($message);
        }

        $this->languageCiphers[$caesarCipher->getLanguage()->name] = $caesarCipher;
    }

    public function encode(string $string, int $key, Language $language): string
    {
        return $this->getConcreteCipher($language)->encode($string, $key);
    }

    public function decode(string $string, int $key, Language $language): string
    {
        return $this->getConcreteCipher($language)->decode($string, $key);
    }

    public function decodeWithoutKey(string $string, Language $language): array
    {
        $caesarCiphers = $this->getConcreteCipher($language);
        $length = mb_strlen($caesarCiphers->getAbc());

        $result = [];
        for ($i = 1; $i < $length; $i++) {
            $result[] = $caesarCiphers->decode($string, $i);
        }

        return $result;
    }

    /**
     * @throws NotFoundLanguageCaesarException
     */
    private function getConcreteCipher(Language $language): LanguageCaesarCipherInterface
    {
        if (!isset($this->languageCiphers[$language->name])) {
            $message = sprintf('Language "%s" not found.', $language->name);
            throw new NotFoundLanguageCaesarException($message);
        }

        return $this->languageCiphers[$language->name];
    }
}
