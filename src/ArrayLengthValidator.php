<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class ArrayLengthValidator extends Validator
{
    private const string TOO_MANY_ELEMENTS = 'tooMany';
    private const string TOO_FEW_ELEMENTS = 'tooFew';

    private ?int $min = null;
    private ?int $max = null;

    public function isValid(mixed $value): bool
    {
        if (!is_array($value)) {
            return true;
        }

        $length = count($value);

        if ($this->max !== null && $length > $this->max) {
            $this->addError(self::TOO_MANY_ELEMENTS, ['max' => $this->max]);
            return false;
        }

        if ($this->min !== null && $length < $this->min) {
            $this->addError(self::TOO_FEW_ELEMENTS, ['min' => $this->min]);
            return false;
        }

        return true;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(?int $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(?int $max): self
    {
        $this->max = $max;
        return $this;
    }
}
