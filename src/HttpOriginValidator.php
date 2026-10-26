<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
final class HttpOriginValidator extends Validator
{
    private const string INVALID_TYPE = 'invalidType';
    private const string INVALID = 'invalid';

    public function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            $this->addError(self::INVALID_TYPE);
            return false;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            $this->addError(self::INVALID);
            return false;
        }

        $parts = parse_url($value);
        if (!is_array($parts)) {
            $this->addError(self::INVALID);
            return false;
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = (string) ($parts['host'] ?? '');
        $port = $parts['port'] ?? null;

        if (!in_array($scheme, ['http', 'https'], true)
            || $host === ''
            || ($port !== null && $port < 1)
            || array_key_exists('path', $parts)
            || array_key_exists('query', $parts)
            || array_key_exists('fragment', $parts)
            || array_key_exists('user', $parts)
            || array_key_exists('pass', $parts)
        ) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }
}
