<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class UnsignedWord extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 2) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Word.");
        }

        parent::__construct($value, $endianness, false);
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function getHighByte(): UnsignedByte
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedByte($value[$endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 1 : 0], $endianness);
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function getLowByte(): UnsignedByte
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedByte($value[$endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 0 : 1], $endianness);
    }
}