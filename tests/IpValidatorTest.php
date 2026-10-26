<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\IpValidator;

final class IpValidatorTest extends TestCase
{
    public function test_accepts_ipv4_and_ipv6_by_default(): void
    {
        $v = new IpValidator();

        $this->assertTrue($v->isValid('127.0.0.1'));
        $this->assertTrue($v->isValid('2001:db8::1'));

        $this->assertFalse($v->isValid('not-an-ip'));
        $this->assertSame('validation.ip.invalid', $v->getErrors()[0]->getCode());
    }

    public function test_version_restrictions_work(): void
    {
        $v4 = new IpValidator(4);
        $this->assertTrue($v4->isValid('127.0.0.1'));
        $this->assertFalse($v4->isValid('2001:db8::1'));

        $v6 = new IpValidator(6);
        $this->assertTrue($v6->isValid('2001:db8::1'));
        $this->assertFalse($v6->isValid('127.0.0.1'));
    }
}
