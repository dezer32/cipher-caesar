<?php

namespace Dezer32\Cipher\Caesar\Contracts;

use Dezer32\Cipher\Caesar\Enum\CaseStrategy;
use Dezer32\Cipher\Caesar\Enum\Language;

interface LanguageCaesarCipherInterface
{
    public function encode(
        string $string,
        int $key,
        CaseStrategy $caseStrategy = CaseStrategy::MAINTAIN_CASE
    ): string;

    public function decode(
        string $string,
        int $key,
        CaseStrategy $caseStrategy = CaseStrategy::MAINTAIN_CASE
    ): string;

    public function getAbc(): string;

    public function getLanguage(): Language;
}
