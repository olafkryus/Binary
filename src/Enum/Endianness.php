<?php
declare(strict_types=1);

namespace Kryus\Binary\Enum;

final class Endianness
{
    public const ENDIANNESS_LITTLE_ENDIAN = 0;
    public const ENDIANNESS_BIG_ENDIAN = 1;

    private function __construct()
    {
    }

    private static function getValidValues(): array
    {
        return [
            self::ENDIANNESS_LITTLE_ENDIAN,
            self::ENDIANNESS_BIG_ENDIAN,
        ];
    }

    public static function isValid(int $value): bool
    {
        return in_array($value, self::getValidValues(), true);
    }
}