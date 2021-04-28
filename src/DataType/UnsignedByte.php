<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class UnsignedByte extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 1) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Byte.");
        }

        parent::__construct($value, $endianness, false);
    }

    /**
     * @return Byte
     * @throws \Exception
     */
    public function asSigned(): Byte
    {
        return new Byte($this->__toString(), $this->getEndianness());
    }

    /**
     * @return Byte
     * @throws \Exception
     */
    public function toSigned(): Byte
    {
        $value = $this->asSigned();

        if ($value->toInt() < 0) {
            throw new \Exception("Value too big for type Byte.");
        }

        return $value;
    }

    /**
     * @return int
     */
    public function getHighNibble(): int
    {
        $value = $this->toInt();

        return ($value >> 4) % 16;
    }

    /**
     * @return int
     */
    public function getLowNibble(): int
    {
        $value = $this->toInt();

        return $value % 16;
    }
}