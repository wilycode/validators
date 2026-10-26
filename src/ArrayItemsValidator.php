<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
use WilyCode\Validator\ValidatorInterface;

class ArrayItemsValidator extends Validator
{
    private const string INVALID = 'invalidType';

    /** @var list<ValidatorInterface> */
    private array $validators;

    public function __construct(ValidatorInterface ...$validators)
    {
        $this->validators = $validators;
    }

    public function isValid(mixed $value): bool
    {
        if (!is_array($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        $isValid = true;

        foreach ($value as $index => $item) {
            foreach ($this->validators as $validator) {
                $validator->clearErrors();

                if (!$validator->isValid($item)) {
                    $this->getErrorBag()
                        ->getOrCreateItem($index)
                        ->merge($validator->getErrorBag());
                    $isValid = false;

                    if ($validator->isStop()) {
                        break;
                    }
                }
            }
        }

        return $isValid;
    }

    /** @return list<ValidatorInterface> */
    public function getValidators(): array
    {
        return $this->validators;
    }

    public function __clone(): void
    {
        $this->validators = array_map(
            static fn(ValidatorInterface $validator): ValidatorInterface => clone $validator,
            $this->validators,
        );

        $this->clearErrors();
    }
}
