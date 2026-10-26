<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
use DateTime;

class DateValidator extends Validator
{
    private const string INVALID_FORMAT = 'invalidFormat';
    private const string TOO_EARLY = 'tooEarly';
    private const string TOO_LATE = 'tooLate';

    private ?string $start;
    private ?string $end;
    private string $format;

    public function __construct(string $format = 'Y-m-d', ?string $start = null, ?string $end = null)
    {
        $this->format = $format;
        $this->start = $start;
        $this->end = $end;
    }

    public function isValid(mixed $value): bool
    {
        $value = (string) $value;

        $d = DateTime::createFromFormat($this->format, $value);
        $errors = DateTime::getLastErrors() ?: ['warning_count' => 0, 'error_count' => 0];

        if ($d === false
            || $errors['warning_count'] > 0
            || $errors['error_count'] > 0
            || $d->format($this->format) !== $value
        ) {
            $this->addError(self::INVALID_FORMAT, ['format' => $this->format]);
            return false;
        }

        $timeValue = $d->getTimestamp();

        if ($this->start !== null) {
            $startTs = strtotime($this->start);
            if ($startTs !== false && $timeValue < $startTs) {
                $this->addError(self::TOO_EARLY, ['start' => $this->start]);
                return false;
            }
        }

        if ($this->end !== null) {
            $endTs = strtotime($this->end);
            if ($endTs !== false && $timeValue > $endTs) {
                $this->addError(self::TOO_LATE, ['end' => $this->end]);
                return false;
            }
        }

        return true;
    }
}