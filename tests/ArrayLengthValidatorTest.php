<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\ArrayLengthValidator;

final class ArrayLengthValidatorTest extends TestCase
{
    public function test_min_and_max_constraints_work(): void
    {
        $validator = new ArrayLengthValidator()->setMin(2)->setMax(3);

        $this->assertFalse($validator->isValid([1]));
        $this->assertSame('validation.array_length.too_few', $validator->getErrors()[0]->getCode());

        $validator->clearErrors();
        $this->assertFalse($validator->isValid([1, 2, 3, 4]));
        $this->assertSame('validation.array_length.too_many', $validator->getErrors()[0]->getCode());

        $validator->clearErrors();
        $this->assertTrue($validator->isValid([1, 2]));
    }

    public function test_non_array_is_left_to_array_validator(): void
    {
        $validator = new ArrayLengthValidator()->setMin(1);

        $this->assertTrue($validator->isValid('value'));
        $this->assertSame([], $validator->getErrors());
    }
}
