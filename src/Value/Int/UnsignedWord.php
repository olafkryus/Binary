<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\IntegerValue;

class UnsignedWord extends IntegerValue implements WordInterface, UnsignedValueInterface
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
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Word.");
        }

        parent::__construct($this->getType(), $value, $endianness);
    }

    public function getType(): Type\Int\UnsignedWord
    {
        return new Type\Int\UnsignedWord();
    }

    /**
     * @return Word
     * @throws \Exception
     */
    public function toSigned(): Word
    {
        $value = $this->asSigned();

        if ($value->toInt() < 0) {
            throw new \Exception("Value too big for type Word.");
        }

        return $value;
    }

    /**
     * @return Word
     * @throws \Exception
     */
    public function asSigned(): Word
    {
        return new Word($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedWord
     */
    public function asUnsigned(): UnsignedWord
    {
        return clone $this;
    }

    /**
     * @return UnsignedWord
     */
    public function toUnsigned(): UnsignedWord
    {
        return clone $this;
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function getHighByte(): UnsignedByte
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedByte($value[$endianness === Endianness::ENDIANNESS_LITTLE_ENDIAN ? 1 : 0], $endianness);
    }

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function getLowByte(): UnsignedByte
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedByte($value[$endianness === Endianness::ENDIANNESS_LITTLE_ENDIAN ? 0 : 1], $endianness);
    }
}