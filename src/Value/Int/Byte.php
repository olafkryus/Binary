<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\IntegerValue;

class Byte extends IntegerValue implements ByteInterface, SignedValueInterface
{
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

    public function getType(): Type\IntegerTypeInterface
    {
        return new Type\Int\Byte();
    }

    /**
     * @return Byte
     */
    public function asSigned(): Byte
    {
        return clone $this;
    }

    /**
     * @return Byte
     */
    public function toSigned(): Byte
    {
        return clone $this;
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedByte
    {
        if ($this->isNegative()) {
            throw new \Exception("Value too small for type Unsigned Byte.");
        }

        return $this->asUnsigned();
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function asUnsigned(): UnsignedByte
    {
        return new UnsignedByte($this->__toString(), $this->getEndianness());
    }
}