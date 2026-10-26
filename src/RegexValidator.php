<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;

class RegexValidator extends Validator
{
    private const string INVALID_TYPE = 'invalidType';
    private const string INVALID_PATTERN = 'invalidPattern';
    private const string PATTERN_MISMATCH = 'patternMismatch';

    private string $pattern;

    /**
     * @param string $pattern A PCRE pattern with delimiters (e.g. '/^[a-z]+$/i').
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            $this->addError(self::INVALID_TYPE);
            return false;
        }

        $result = @preg_match($this->pattern, $value);

        if ($result === false) {
            $this->addError(self::INVALID_PATTERN, ['pattern' => $this->pattern]);
            return false;
        }

        if ($result !== 1) {
            $this->addError(self::PATTERN_MISMATCH);
            return false;
        }

        return true;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }
}
