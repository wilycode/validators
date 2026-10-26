<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use WilyCode\Validators\JsonValidator;

final class JsonValidatorTest extends TestCase
{
    public function test_validates_json_and_reports_errors(): void
    {
        $v = new JsonValidator();

        $this->assertTrue($v->isValid('{"a":1}'));
        $this->assertTrue($v->isValid('[1,2,3]'));

        $this->assertFalse($v->isValid('{"a":}'));
        $this->assertSame('validation.json.invalid', $v->getErrors()[0]->getCode());
    }

    public function test_top_level_expectations_work(): void
    {
        $arr = new JsonValidator()->expectArray();
        $this->assertTrue($arr->isValid('[1]'));
        $this->assertFalse($arr->isValid('{"a":1}'));
        $this->assertSame('validation.json.expected_array', $arr->getErrors()[0]->getCode());

        $obj = new JsonValidator()->expectObject();
        $this->assertTrue($obj->isValid('{"a":1}'));
        $this->assertFalse($obj->isValid('[1]'));
        $this->assertSame('validation.json.expected_object', $obj->getErrors()[0]->getCode());
    }
}
