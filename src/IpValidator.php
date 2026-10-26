<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
use InvalidArgumentException;

class IpValidator extends Validator
{
    private const string INVALID = 'invalid';

    /**
     * null  => accept IPv4 and IPv6
     * 4     => accept IPv4 only
     * 6     => accept IPv6 only
     */
    private ?int $version;

    public function __construct(?int $version = null)
    {
        if ($version !== null && $version !== 4 && $version !== 6) {
            throw new InvalidArgumentException('IP version must be null, 4 or 6.');
        }
        $this->version = $version;
    }

    public function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            $this->addError(self::INVALID);
            return false;
        }

        $flags = 0;
        if ($this->version === 4) {
            $flags = FILTER_FLAG_IPV4;
        } elseif ($this->version === 6) {
            $flags = FILTER_FLAG_IPV6;
        }

        if (filter_var($value, FILTER_VALIDATE_IP, $flags) === false) {
            $this->addError(self::INVALID);
            return false;
        }

        return true;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $version): self
    {
        if ($version !== null && $version !== 4 && $version !== 6) {
            throw new InvalidArgumentException('IP version must be null, 4 or 6.');
        }
        $this->version = $version;
        return $this;
    }
}
