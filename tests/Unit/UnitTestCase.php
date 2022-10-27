<?php

namespace Dezer32\Cipher\Caesar\Tests\Unit;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    private const FAKER_GENERATOR_LANGUAGE = 'ru_RU';

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create(self::FAKER_GENERATOR_LANGUAGE);
    }
}
