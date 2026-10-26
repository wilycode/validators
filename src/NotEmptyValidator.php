<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class NotEmptyValidator extends Validator
{
    private const string REQUIRED = 'required';
    private mixed $emptyValue;

    public function __construct(mixed $emptyValue = '')
    {
        $this->setStop(true);
        $this->emptyValue = $emptyValue;
    }

    public function isValid(mixed $value): bool
    {
        if ($this->emptyValue === $value || $value === null) {
            $this->addError(self::REQUIRED);
            return false;
        }

        return true;
    }
}