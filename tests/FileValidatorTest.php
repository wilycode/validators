<?php

declare(strict_types=1);

namespace WilyCode\Validators\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use WilyCode\Validators\Enums\FileSizeUnit;
use WilyCode\Validators\FileValidator;

final class FileValidatorTest extends TestCase
{
    private function makeUploadedFile(
        int $error,
        int $size,
        ?string $clientFilename = 'file.txt',
        ?string $clientMediaType = 'text/plain'
    ): UploadedFileInterface {
        $stream = new class implements StreamInterface {
            public function __toString(): string { return ''; }
            public function close(): void {}
            public function detach() { return null; }
            public function getSize(): ?int { return 0; }
            public function tell(): int { return 0; }
            public function eof(): bool { return true; }
            public function isSeekable(): bool { return false; }
            public function seek(int $offset, int $whence = SEEK_SET): void {}
            public function rewind(): void {}
            public function isWritable(): bool { return false; }
            public function write(string $string): int { return 0; }
            public function isReadable(): bool { return false; }
            public function read(int $length): string { return ''; }
            public function getContents(): string { return ''; }
            public function getMetadata(?string $key = null) { return null; }
        };

        return new class($error, $size, $clientFilename, $clientMediaType, $stream) implements UploadedFileInterface {
            public function __construct(
                private int $error,
                private int $size,
                private ?string $clientFilename,
                private ?string $clientMediaType,
                private StreamInterface $stream
            ) {}

            public function getStream(): StreamInterface { return $this->stream; }
            public function moveTo(string $targetPath): void {}
            public function getSize(): ?int { return $this->size; }
            public function getError(): int { return $this->error; }
            public function getClientFilename(): ?string { return $this->clientFilename; }
            public function getClientMediaType(): ?string { return $this->clientMediaType; }
        };
    }

    public function test_no_file_upload_is_accepted_as_empty_value(): void
    {
        $file = $this->makeUploadedFile(UPLOAD_ERR_NO_FILE, 0);
        $validator = new FileValidator();

        $this->assertTrue($validator->isValid($file));
        $this->assertSame([], $validator->getErrors());
    }

    public function test_size_and_mime_and_extension_constraints_are_enforced(): void
    {
        $file = $this->makeUploadedFile(UPLOAD_ERR_OK, 2048, 'report.pdf', 'application/pdf');

        $validator = new FileValidator()
            ->setSizeMax(1, FileSizeUnit::KB)
            ->setMimeTypes(['image/png'])
            ->setExtensions(['png']);

        $this->assertFalse($validator->isValid($file));

        $names = array_map(fn($e) => $e->getCode(), $validator->getErrors());
        $this->assertContains('validation.file.too_large', $names);
        $this->assertContains('validation.file.invalid_type', $names);
        $this->assertContains('validation.file.invalid_extension', $names);
    }

    public function test_fractional_size_limit_is_converted_to_an_integer_byte_limit(): void
    {
        $validator = new FileValidator()->setSizeMax(1.5, FileSizeUnit::MB);

        $this->assertSame(1572864, $validator->getSizeMax(true));
    }
}
