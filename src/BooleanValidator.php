<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class BooleanValidator extends Validator
{
    private const string INVALID = 'invalid';

    public function isValid(mixed $value): bool
    {
        if (!is_bool($value))
        {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }
}