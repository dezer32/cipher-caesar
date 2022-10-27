<?php

namespace Dezer32\Cipher\Caesar\Helpers;

use Dezer32\Cipher\Caesar\Enum\CaseStrategy;

class ImplodeChunksCaesarHelper extends AbstractHelper
{
    public function implodes(array $chunks, string $string, CaseStrategy $caseStrategy): string
    {
        $chunksCaseStrategy = $this->caseStrategy($chunks, $string, $caseStrategy);

        return implode('', $chunksCaseStrategy);
    }

    private function caseStrategy(
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
}
