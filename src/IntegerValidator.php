<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class IntegerValidator extends Validator
{
    private const string INVALID = 'invalid';
    private const string TOO_SMALL = 'tooSmall';
    private const string TOO_LARGE = 'tooLarge';

    private ?int $max = null;
    private ?int $min = null;

    public function isValid(mixed $value): bool
    {
        if (!is_int($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        if ($this->getMax() !== null && $value > $this->getMax()) {
            $this->addError(self::TOO_LARGE);
            return false;
        }

        if ($this->getMin() !== null && $value < $this->getMin()) {
            $this->addError(self::TOO_SMALL);
            return false;
        }

        return true;
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

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(?int $min): self
    {
        $this->min = $min;
        return $this;
    }
}