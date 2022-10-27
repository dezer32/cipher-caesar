<?php

namespace Dezer32\Cipher\Caesar;

use Dezer32\Cipher\Caesar\Contracts\LanguageCaesarCipherInterface;
use Dezer32\Cipher\Caesar\Enum\CaseStrategy;
use Dezer32\Cipher\Caesar\Exceptions\UnexpectedSymbolCaesarException;

abstract class AbstractLanguageCaesarCipher implements LanguageCaesarCipherInterface
{
    //todo Или сделать параметр регистрозависимости (strict)
    public function encode(
        string $string,
        int $key,
        CaseStrategy $caseStrategy = CaseStrategy::MAINTAIN_CASE
    ): string {
        $chunks = $this->splitString($string);

        foreach ($chunks as $i => $char) {
            try {
                $chunks[$i] = $this->encodeChar($char, $key);
            } catch (UnexpectedSymbolCaesarException $e) {
                // nothing here..
            }
        }

        return $this->implodeChunks($chunks, $string, $caseStrategy);
    }

    public function decode(
        string $string,
        int $key,
        CaseStrategy $caseStrategy = CaseStrategy::MAINTAIN_CASE
    ): string {
        $chunks = $this->splitString($string);

        foreach ($chunks as $i => $char) {
            try {
                $chunks[$i] = $this->decodeChar($char, $key);
            } catch (UnexpectedSymbolCaesarException $e) {
                // nothing here..
            }
        }

        return $this->implodeChunks($chunks, $string, $caseStrategy);
    }

    private function splitString(string $string): array
    {
        $lowerString = mb_strtolower($string);

        return mb_str_split($lowerString);
    }

    private function chunksCaseStrategy(
        array $chunks,
        string $string,
        CaseStrategy $caseStrategy
    ): array {
        return match ($caseStrategy) {
            CaseStrategy::MAINTAIN_CASE => $this->maintainCase($chunks, $string),
            CaseStrategy::IGNORE_CASE => $chunks,
            CaseStrategy::STRICT_CASE => $this->strictCase($chunks, $string)
        };
    }

    private function implodeChunks(array $chunks, string $string, CaseStrategy $caseStrategy): string
    {
        $chunksCaseStrategy = $this->chunksCaseStrategy($chunks, $string, $caseStrategy);

        return implode('', $chunksCaseStrategy);
    }

    /**
     * @throws UnexpectedSymbolCaesarException
     */
    private function encodeChar(string $char, int $key): string
    {
        $serial = $this->getSerial($char);
        $newSerial = $this->calculate($serial, $key);

        return $this->getSerialChar($newSerial);
    }

    /**
     * @throws UnexpectedSymbolCaesarException
     */
    private function decodeChar(string $char, int $key): string
    {
        $serial = $this->getSerial($char);
        $reverseSerial = $this->getReverseChar($serial);
        $decodedReverseSerial = $this->calculate($reverseSerial, $key);
        $decodedSerial = $this->getReverseChar($decodedReverseSerial);

        return $this->getSerialChar($decodedSerial);
    }

    private function calculate(int $serial, int $key): int
    {
        return ($serial + $key) % $this->getAbcPower();
    }

    private function getReverseChar(int $serial): int
    {
        return $this->getAbcPower() - $serial - 1;
    }

    private function getAbcPower(): int
    {
        return mb_strlen($this->getAbc());
    }

    private function maintainCase(array $chunks, string $string): array
    {
        return array_map(
            static function (string $encodedChar, string $char): string {
                if ($char === mb_strtoupper($char)) {
                    $encodedChar = mb_strtoupper($encodedChar);
                }

                return $encodedChar;
            },
            $chunks,
            mb_str_split($string)
        );
    }

    private function strictCase(array $chunks, string $string): array
    {
        return array_map(
            static function (string $encodedChar, string $char): string {
                if ($char === mb_strtoupper($char)) {
                    $encodedChar = $char;
                }

                return $encodedChar;
            },
            $chunks,
            mb_str_split($string)
        );
    }

    /**
     * @throws UnexpectedSymbolCaesarException
     */
    private function getSerial(string $char): int
    {
        $position = mb_strpos($this->getAbc(), $char);

        if ($position === false) {
            $message = sprintf('Unexpected symbol "%s".', $char);

            throw new UnexpectedSymbolCaesarException($message);
        }

        return $position;
    }

    private function getSerialChar(int $serial): string
    {
        return mb_substr($this->getAbc(), $serial, 1);
    }
}
