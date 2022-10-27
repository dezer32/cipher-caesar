<?php

namespace Dezer32\Cipher\Caesar\Tests\Unit;

use Dezer32\Cipher\Caesar\CaesarCipher;
use Dezer32\Cipher\Caesar\Contracts\CaesarCipherInterface;
use Dezer32\Cipher\Caesar\Contracts\LanguageCaesarCipherInterface;
use Dezer32\Cipher\Caesar\Enum\Language;
use Dezer32\Cipher\Caesar\Exceptions\ExistLanguageCaesarException;

class CaesarCipherUnitTest extends UnitTestCase
{
    private CaesarCipherInterface $caesarCipher;
    private LanguageCaesarCipherInterface $ruCaesarCipher;
    private LanguageCaesarCipherInterface $enCaesarCipher;

    private const ABC = 'abc';

    public function testSuccessCanEncodeEn(): void
    {
        $string = $this->faker->text();
        $key = $this->faker->randomDigit();
        $expectedString = $this->faker->text();

        $this->enCaesarCipher
            ->expects(self::once())
            ->method('encode')
            ->with($string, $key)
            ->willReturn($expectedString);

        $response = $this->caesarCipher->encode($string, $key, Language::EN);

        self::assertSame($expectedString, $response);
    }

    public function testSuccessCanEncodeRu(): void
    {
        $string = $this->faker->text();
        $key = $this->faker->randomDigit();
        $expectedString = $this->faker->text();

        $this->ruCaesarCipher
            ->expects(self::once())
            ->method('encode')
            ->with($string, $key)
            ->willReturn($expectedString);

        $response = $this->caesarCipher->encode($string, $key, Language::RU);

        self::assertSame($expectedString, $response);
    }

    public function testSuccessCanDecodeEn(): void
    {
        $string = $this->faker->text();
        $key = $this->faker->randomDigit();
        $expectedString = $this->faker->text();

        $this->enCaesarCipher
            ->expects(self::once())
            ->method('decode')
            ->with($string, $key)
            ->willReturn($expectedString);

        $response = $this->caesarCipher->decode($string, $key, Language::EN);

        self::assertSame($expectedString, $response);
    }

    public function testSuccessCanDecodeRu(): void
    {
        $string = $this->faker->text();
        $key = $this->faker->randomDigit();
        $expectedString = $this->faker->text();

        $this->ruCaesarCipher
            ->expects(self::once())
            ->method('decode')
            ->with($string, $key)
            ->willReturn($expectedString);

        $response = $this->caesarCipher->decode($string, $key, Language::RU);

        self::assertSame($expectedString, $response);
    }

    public function testErrorReAddLang(): void
    {
        $this->expectException(ExistLanguageCaesarException::class);
        $this->caesarCipher->addLanguage($this->ruCaesarCipher);
    }

    public function testSuccessCanDecodeWithoutKey(): void
    {
        $string = $this->faker->text();
        $expectedResponse = [
            $this->faker->text(),
            $this->faker->text(),
        ];

        $this->ruCaesarCipher
            ->expects(self::exactly(2))
            ->method('decode')
            ->withConsecutive([$string, 1], [$string, 2])
            ->willReturnOnConsecutiveCalls(...$expectedResponse);

        $response = $this->caesarCipher->decodeWithoutKey($string, Language::RU);

        self::assertSame($expectedResponse, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->ruCaesarCipher = $this->createMock(LanguageCaesarCipherInterface::class);
        $this->ruCaesarCipher
            ->method('getAbc')
            ->willReturn(self::ABC);
        $this->ruCaesarCipher
            ->method('getLanguage')
            ->willReturn(Language::RU);

        $this->enCaesarCipher = $this->createMock(LanguageCaesarCipherInterface::class);
        $this->enCaesarCipher
            ->method('getAbc')
            ->willReturn(self::ABC);
        $this->enCaesarCipher
            ->method('getLanguage')
            ->willReturn(Language::EN);

        $this->caesarCipher = new CaesarCipher();

        $this->caesarCipher->addLanguage($this->ruCaesarCipher);
        $this->caesarCipher->addLanguage($this->enCaesarCipher);
    }
}
