<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class StringLengthValidator extends Validator
{
    private const string TOO_SHORT = 'tooShort';
    private const string TOO_LONG = 'tooLong';
    private ?int $min = null;
    private ?int $max = null;

    public function isValid(mixed $value): bool
    {
        $value = (string) $value;
        $length = mb_strlen($value);

        if ($this->getMin() !== null && $length < $this->getMin()) {
            $this->addError(self::TOO_SHORT, ['min' => $this->getMin()]);
            return false;
        }

        if ($this->getMax() !== null && $length > $this->getMax()) {
            $this->addError(self::TOO_LONG, ['max' => $this->getMax()]);
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