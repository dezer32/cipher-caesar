<?php

namespace Dezer32\Cipher\Caesar\Tests\Unit;

use Dezer32\Cipher\Caesar\Contracts\LanguageCaesarCipherInterface;
use Dezer32\Cipher\Caesar\EnCaesarCipher;
use Dezer32\Cipher\Caesar\RuCaesarCipher;

class EnCaesarCipherUnitTest extends UnitTestCase
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
            'Mom washed the frame.',
            0,
            'Mom washed the frame.',
        ];

        yield [
            'Mom washed the frame.',
            1,
            'Npn xbtife uif gsbnf.',
        ];

        yield [
            'a',
            1,
            'b',
        ];

        yield [
            'z',
            1,
            'a',
        ];

        yield [
            'Mom washed the frame. Мама мыла раму.',
            1,
            'Npn xbtife uif gsbnf. Мама мыла раму.',
        ];

        yield [
            'Mom washed the frame.',
            25,
            'Lnl vzrgdc sgd eqzld.',
        ];

        yield [
            'Mom washed the frame.',
            26,
            'Mom washed the frame.',
        ];

        yield [
            'Mom washed the frame.',
            27,
            'Npn xbtife uif gsbnf.',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->caesarCipher = new EnCaesarCipher();
    }
}
