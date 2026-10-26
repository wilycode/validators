<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\TimeValidator;

final class TimeValidatorTest extends TestCase
{
    public function test_accepts_valid_24_hour_time(): void
    {
        $validator = new TimeValidator();

        $this->assertTrue($validator->isValid('00:00'));
        $this->assertTrue($validator->isValid('09:05'));
        $this->assertTrue($validator->isValid('23:59'));
        $this->assertSame([], $validator->getErrors());
    }

    public function test_accepts_empty_optional_value(): void
    {
        $validator = new TimeValidator();

        $this->assertTrue($validator->isValid(null));
        $this->assertTrue($validator->isValid(''));
        $this->assertSame([], $validator->getErrors());
    }

    public function test_rejects_invalid_time(): void
    {
        $validator = new TimeValidator();

        foreach (['9:05', '24:00', '23:60', '12:30:00', 'noon'] as $value) {
            $validator->clearErrors();

            $this->assertFalse($validator->isValid($value));
            $this->assertSame('validation.time.invalid', $validator->getErrors()[0]->getCode());
        }
    }

    public function test_rejects_non_string_value(): void
    {
        $validator = new TimeValidator();

        $this->assertFalse($validator->isValid(930));
        $this->assertSame('validation.time.invalid', $validator->getErrors()[0]->getCode());
    }
}
