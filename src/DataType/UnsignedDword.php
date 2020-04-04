<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class UnsignedDword extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 4) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Dword.");
        }

        parent::__construct($value, $endianness, false);
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function getHighWord(): UnsignedWord
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedWord(substr($value, $endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 2 : 0, 2), $endianness);
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function getLowWord(): UnsignedWord
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedWord(substr($value, $endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 0 : 2, 2), $endianness);
    }
}