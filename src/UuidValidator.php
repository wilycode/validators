<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class UuidValidator extends Validator
{
    private const string INVALID = 'invalid';

    private bool $allowNil = false;

    public function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        $value = trim($value);

        if ($this->allowNil && $value === '00000000-0000-0000-0000-000000000000') {
            return true;
        }

        // RFC 4122 variant for versions 1-5.
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value)) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }

    public function isAllowNil(): bool
    {
        return $this->allowNil;
    }

    public function setAllowNil(bool $allowNil): self
    {
        $this->allowNil = $allowNil;
        return $this;
    }
}
