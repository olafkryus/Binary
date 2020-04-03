<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class UnsignedByte extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 1) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Byte.");
        }

        parent::__construct($value, $endianness, false);
    }
}