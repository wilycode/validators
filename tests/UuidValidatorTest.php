<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\UuidValidator;

final class UuidValidatorTest extends TestCase
{
    public function test_uuid_validation(): void
    {
        $v = new UuidValidator();

        $this->assertTrue($v->isValid('550e8400-e29b-41d4-a716-446655440000'));

        $this->assertFalse($v->isValid('not-a-uuid'));
        $this->assertSame('validation.uuid.invalid', $v->getErrors()[0]->getCode());
    }

    public function test_nil_uuid_can_be_allowed(): void
    {
        $v = new UuidValidator()->setAllowNil(true);

        $this->assertTrue($v->isValid('00000000-0000-0000-0000-000000000000'));
    }
}
