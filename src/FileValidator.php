<?php

declare(strict_types=1);

namespace WilyCode\Validators;

use WilyCode\Validator\Validator;
use Psr\Http\Message\UploadedFileInterface;
use WilyCode\Validators\Enums\FileSizeUnit;

class FileValidator extends Validator
{
    public const string UPLOAD_ERROR = 'uploadError';
    public const string TOO_SMALL = 'tooSmall';
    public const string TOO_LARGE = 'tooLarge';
    public const string INVALID_TYPE = 'invalidType';
    public const string INVALID_EXTENSION = 'invalidExtension';

    private float|int|null $sizeMax = null;
    private ?FileSizeUnit $sizeMaxUnit = null;
    private float|int|null $sizeMin = null;
    private ?FileSizeUnit $sizeMinUnit = null;

    /**
     * @var string[]
     */
    private ?array $extensions = null;

    /**
     * @var string[]
     */
    private ?array $mimeTypes = null;

    
    public function isValid(mixed $value): bool
    {
        $isValid = true;

        if ($value === null || $value === '' || $value === []) {
            return true;
        }

        if ($value instanceof UploadedFileInterface && $value->getError() === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (!($value instanceof UploadedFileInterface) || $value->getError() !== UPLOAD_ERR_OK)
        {
            $this->addError(self::UPLOAD_ERROR);
            return false;
        }

        if ($this->getSizeMax() !== null && $value->getSize() > $this->getSizeMax(true))
        {
            $this->addError(self::TOO_LARGE, ['sizeMax' => $this->getSizeMax(), 'sizeUnit' => $this->getSizeMaxUnit()]);
            $isValid = false;
        }

        if ($this->getSizeMin() !== null && $value->getSize() < $this->getSizeMin(true))
        {
            $this->addError(self::TOO_SMALL, ['sizeMin' => $this->getSizeMin(), 'sizeUnit' => $this->getSizeMinUnit()]);
            $isValid = false;
        }

        if ($this->getMimeTypes() !== null && !in_array($value->getClientMediaType(), $this->getMimeTypes()))
        {
            $this->addError(self::INVALID_TYPE);
            $isValid = false;
        }

        if ($this->getExtensions() !== null && !in_array(pathinfo($value->getClientFilename(), PATHINFO_EXTENSION), $this->getExtensions()))
        {
            $this->addError(self::INVALID_EXTENSION, ['extensions' => implode(', ', $this->getExtensions())]);
            $isValid = false;
        }

        return $isValid;
    }

    public function getSizeMax(bool $asBytes = false): float|int|null
    {
        if ($asBytes && $this->sizeMax !== null && $this->sizeMaxUnit !== null) {
            return $this->getValueAsBytes($this->sizeMax, $this->sizeMaxUnit);
        }

        return $this->sizeMax;
    }

    public function setSizeMax(float|int|null $sizeMax, FileSizeUnit $unit = FileSizeUnit::MB): FileValidator
    {
        $this->sizeMax = $sizeMax;
        $this->sizeMaxUnit = $unit;
        return $this;
    }

    public function getSizeMin(bool $asBytes = false): float|int|null
    {
        if ($asBytes && $this->sizeMin !== null && $this->sizeMinUnit !== null) {
            return $this->getValueAsBytes($this->sizeMin, $this->sizeMinUnit);
        }

        return $this->sizeMin;
    }

    public function setSizeMin(float|int|null $sizeMin, FileSizeUnit $unit = FileSizeUnit::MB): FileValidator
    {
        $this->sizeMin = $sizeMin;
        $this->sizeMinUnit = $unit;
        return $this;
    }

    public function getSizeMaxUnit(): ?FileSizeUnit
    {
        return $this->sizeMaxUnit;
    }

    public function setSizeMaxUnit(?FileSizeUnit $sizeMaxUnit): void
    {
        $this->sizeMaxUnit = $sizeMaxUnit;
    }

    /**
     * @return string[]|null
     */
    public function getExtensions(): ?array
    {
        return $this->extensions;
    }

    /**
     * @param string[] $extensions
     */
    public function setExtensions(?array $extensions): FileValidator
    {
        $this->extensions = $extensions;
        return $this;
    }

    public function getSizeMinUnit(): ?FileSizeUnit
    {
        return $this->sizeMinUnit;
    }

    /**
     * @return string[]|null
     */
    public function getMimeTypes(): ?array
    {
        return $this->mimeTypes;
    }

    /**
     * @param string[] $mimeTypes
     */
    public function setMimeTypes(?array $mimeTypes): FileValidator
    {
        $this->mimeTypes = $mimeTypes;
        return $this;
    }

    private function getValueAsBytes(float|int $value, FileSizeUnit $unit): int
    {
        $multiplier = match ($unit) {
            FileSizeUnit::KB => 1024,
            FileSizeUnit::MB => 1048576,
            FileSizeUnit::GB => 1073741824,
            FileSizeUnit::TB => 1099511627776,
        };

        return (int) round($value * $multiplier);
    }
}
