<?php

namespace Dezer32\Cipher\Caesar\Tests\Unit;

use Dezer32\Cipher\Caesar\Contracts\LanguageCaesarCipherInterface;
use Dezer32\Cipher\Caesar\RuCaesarCipher;

class RuCaesarCipherUnitTest extends UnitTestCase
{
    private LanguageCaesarCipherInterface $caesarCipher;

    /** @dataProvider encodeOrDecodeDataProvider */
    public function testSuccessCanEncode(string $string, int $key, string $expectedString): void
    {
        $encodedString = $this->caesarCipher->encode($string, $key);

        self::assertSame($expectedString, $encodedString);
    }

    /** @dataProvider encodeOrDecodeDataProvider */
    public function testSuccessCanDecode(string $expectedString, int $key, string $encodedString): void
    {
        $decodedString = $this->caesarCipher->decode($encodedString, $key);

        self::assertSame($expectedString, $decodedString);
    }

    public function encodeOrDecodeDataProvider(): iterable
    {
        yield [
            'Мама мыла раму.',
            0,
            'Мама мыла раму.',
        ];

        yield [
            'Мама мыла раму.',
            1,
            'Нбнб ньмб сбнф.',
        ];

        yield [
            'а',
            1,
            'б',
        ];

        yield [
            'я',
            1,
            'а',
        ];

        yield [
            'Мама мыла раму. Mom washed the frame.',
            1,
            'Нбнб ньмб сбнф. Mom washed the frame.',
        ];

        yield [
            'Мама мыла раму.',
            32,
            'Ляля лъкя пялт.',
        ];

        yield [
            'Мама мыла раму.',
            33,
            'Мама мыла раму.',
        ];

        yield [
            'Мама мыла раму.',
            34,
            'Нбнб ньмб сбнф.',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->caesarCipher = new RuCaesarCipher();
    }
}
