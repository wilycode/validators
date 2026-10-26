<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class ArrayValidator extends Validator
{
    private const string INVALID = 'invalidType';

    public function isValid(mixed $value): bool
    {
        if (!is_array($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }
}
