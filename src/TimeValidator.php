<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class TimeValidator extends Validator
{
    private const string INVALID = 'invalid';

    public function isValid(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return true;
        }

        if (!is_string($value) || preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $value) !== 1) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }
}
