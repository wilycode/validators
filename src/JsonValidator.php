<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class JsonValidator extends Validator
{
    private const string INVALID = 'invalid';
    private const string EXPECTED_ARRAY = 'expectedArray';
    private const string EXPECTED_OBJECT = 'expectedObject';

    /** @var null|'array'|'object' */
    private ?string $topLevel = null;

    public function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        $json = trim($value);
        if ($json === '') {
            $this->addError(self::INVALID);
            return false;
        }

        json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError(self::INVALID, ['error' => json_last_error_msg()]);
            return false;
        }

        if ($this->topLevel !== null) {
            $first = $json[0] ?? '';
            if ($this->topLevel === 'array' && $first !== '[') {
                $this->addError(self::EXPECTED_ARRAY);
                return false;
            }
            if ($this->topLevel === 'object' && $first !== '{') {
                $this->addError(self::EXPECTED_OBJECT);
                return false;
            }
        }

        return true;
    }

    public function expectArray(): self
    {
        $this->topLevel = 'array';
        return $this;
    }

    public function expectObject(): self
    {
        $this->topLevel = 'object';
        return $this;
    }

    public function acceptAny(): self
    {
        $this->topLevel = null;
        return $this;
    }

    /** @return null|'array'|'object' */
    public function getTopLevel(): ?string
    {
        return $this->topLevel;
    }
}
