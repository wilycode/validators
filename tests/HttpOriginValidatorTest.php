<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use WilyCode\Validators\HttpOriginValidator;

final class HttpOriginValidatorTest extends TestCase
{
    #[DataProvider('validOrigins')]
    public function test_accepts_http_https_host_and_optional_port(string $origin): void
    {
        self::assertTrue(new HttpOriginValidator()->isValid($origin), $origin);
    }

    /** @return iterable<string, array{string}> */
    public static function validOrigins(): iterable
    {
        yield 'http domain' => ['http://example.com'];
        yield 'https domain' => ['https://example.com'];
        yield 'localhost with port' => ['http://localhost:8081'];
        yield 'ipv4' => ['http://127.0.0.1:8081'];
        yield 'ipv6' => ['http://[::1]:8081'];
    }

    #[DataProvider('invalidOrigins')]
    public function test_rejects_missing_scheme_paths_and_non_origin_urls(string $origin): void
    {
        $validator = new HttpOriginValidator();

        self::assertFalse($validator->isValid($origin), $origin);
        self::assertSame('validation.http_origin.invalid', $validator->getErrors()[0]->getCode());
    }

    /** @return iterable<string, array{string}> */
    public static function invalidOrigins(): iterable
    {
        yield 'missing scheme' => ['example.com'];
        yield 'ftp' => ['ftp://example.com'];
        yield 'trailing slash' => ['https://example.com/'];
        yield 'path' => ['https://example.com/xx'];
        yield 'query' => ['https://example.com?x=1'];
        yield 'fragment' => ['https://example.com#section'];
        yield 'user info' => ['https://user@example.com'];
        yield 'invalid host' => ['https://exa_mple.com'];
        yield 'zero port' => ['https://example.com:0'];
    }
}
