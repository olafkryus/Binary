<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

use Kryus\Binary\DataType\IntegerValue;
use Kryus\Binary\Enum\Endianness;

class Byte extends IntegerValue implements ByteInterface, SignedValueInterface
{
    use SignedValueTrait;

    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== self::BYTE_COUNT) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Byte.");
        }

        parent::__construct($value, $endianness, self::IS_SIGNED);
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function asUnsigned(): UnsignedByte
    {
        return new UnsignedByte($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedByte
    {
        if ($this->toInt() < 0) {
            throw new \Exception("Value too small for type Unsigned Byte.");
        }

        return $this->asUnsigned();
    }
}