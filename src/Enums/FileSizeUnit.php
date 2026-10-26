<?php

declare(strict_types=1);

namespace WilyCode\Validators\Enums;

enum FileSizeUnit: string
{
    case KB = 'KB';
    case MB = 'MB';
    case GB = 'GB';
    case TB = 'TB';
}