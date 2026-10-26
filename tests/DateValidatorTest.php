<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\DateValidator;

final class DateValidatorTest extends TestCase
{
    public function test_invalid_format_returns_error(): void
    {
        $v = new DateValidator('Y-m-d');

        $this->assertFalse($v->isValid('2026-13-40'));
        $this->assertSame('validation.date.invalid_format', $v->getErrors()[0]->getCode());
    }

    public function test_range_checks_add_errors(): void
    {
        $v = new DateValidator('Y-m-d', '2026-01-10', '2026-01-20');

        $this->assertFalse($v->isValid('2026-01-09'));
        $this->assertSame('validation.date.too_early', $v->getErrors()[0]->getCode());

        $v->clearErrors();
        $this->assertFalse($v->isValid('2026-01-21'));
        $this->assertSame('validation.date.too_late', $v->getErrors()[0]->getCode());

        $v->clearErrors();
        $this->assertTrue($v->isValid('2026-01-15'));
        $this->assertSame([], $v->getErrors());
    }
}
