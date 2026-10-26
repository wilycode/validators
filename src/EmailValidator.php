<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class EmailValidator extends Validator
{
    private const string INVALID = 'invalid';

    public function isValid(mixed $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }
}