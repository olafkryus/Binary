<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class Dword extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 4) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Dword.");
        }

        parent::__construct($value, $endianness);
    }

    /**
     * @return UnsignedDword
     * @throws \Exception
     */
    public function asUnsigned(): UnsignedDword
    {
        return new UnsignedDword($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedDword
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedDword
    {
        if ($this->toInt() < 0) {
            throw new \Exception("Value too small for type Unsigned Dword.");
        }

        return $this->asUnsigned();
    }
}