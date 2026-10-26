<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\ArrayValidator;

final class ArrayValidatorTest extends TestCase
{
    public function test_invalid_when_value_is_not_array(): void
    {
        $validator = new ArrayValidator();

        $this->assertFalse($validator->isValid('not-array'));
        $this->assertSame('validation.array.invalid_type', $validator->getErrors()[0]->getCode());
    }

    public function test_valid_when_value_is_array(): void
    {
        $validator = new ArrayValidator();

        $this->assertTrue($validator->isValid([]));
        $this->assertSame([], $validator->getErrors());
    }
}
