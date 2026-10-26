<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
use Closure;

/** Application-specific validation without coupling the form package to infrastructure. */
final class CallbackValidator extends Validator
{
    /**
     * @param Closure(mixed): bool $callback
     * @param array<string, mixed> $errorOptions
     */
    public function __construct(
        private readonly Closure $callback,
        private readonly string $errorCode = 'invalid',
        private readonly array $errorOptions = [],
    ) {
    }

    public function isValid(mixed $value): bool
    {
        if (($this->callback)($value)) {
            return true;
        }

        $this->addError($this->errorCode, $this->errorOptions);
        return false;
    }

    protected function getValidatorCode(): string
    {
        return 'callback';
    }
}
