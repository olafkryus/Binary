<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\IntegerValue;

class UnsignedByte extends IntegerValue implements ByteInterface, UnsignedValueInterface
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
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Byte.");
        }

        parent::__construct($value, $endianness, self::IS_SIGNED);
    }

    public function getType(): Type\IntegerTypeInterface
    {
        return new Type\Int\UnsignedByte();
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
     * @return Byte
     * @throws \Exception
     */
    public function asSigned(): Byte
    {
        return new Byte($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedByte
     */
    public function asUnsigned(): UnsignedByte
    {
        return clone $this;
    }

    /**
     * @return UnsignedByte
     */
    public function toUnsigned(): UnsignedByte
    {
        return clone $this;
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