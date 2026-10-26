<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\RegexValidator;

final class RegexValidatorTest extends TestCase
{
    public function test_validates_strings_against_pattern(): void
    {
        $v = new RegexValidator('/^[a-z]+$/i');

        $this->assertTrue($v->isValid('John'));

        $this->assertFalse($v->isValid('John123'));
        $this->assertSame('validation.regex.pattern_mismatch', $v->getErrors()[0]->getCode());
    }

    public function test_invalid_pattern_returns_error(): void
    {
        $v = new RegexValidator('/[a-z+/'); // invalid PCRE

        $this->assertFalse($v->isValid('abc'));
        $this->assertSame('validation.regex.invalid_pattern', $v->getErrors()[0]->getCode());
    }
}
