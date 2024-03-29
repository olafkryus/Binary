<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\IntegerValue;

class UnsignedDword extends IntegerValue implements DwordInterface, UnsignedValueInterface
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
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Dword.");
        }

        parent::__construct($this->getType(), $value, $endianness);
    }

    public function getType(): Type\Int\UnsignedDword
    {
        return new Type\Int\UnsignedDword();
    }

    /**
     * @return Dword
     * @throws \Exception
     */
    public function toSigned(): Dword
    {
        $value = $this->asSigned();

        if ($value->toInt() < 0) {
            throw new \Exception("Value too big for type Dword.");
        }

        return $value;
    }

    /**
     * @return Dword
     * @throws \Exception
     */
    public function asSigned(): Dword
    {
        return new Dword($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedDword
     */
    public function asUnsigned(): UnsignedDword
    {
        return clone $this;
    }

    /**
     * @return UnsignedDword
     */
    public function toUnsigned(): UnsignedDword
    {
        return clone $this;
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function getHighWord(): UnsignedWord
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedWord(
            substr($value, $endianness === Endianness::ENDIANNESS_LITTLE_ENDIAN ? 2 : 0, 2),
            $endianness
        );
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function getLowWord(): UnsignedWord
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new UnsignedWord(
            substr($value, $endianness === Endianness::ENDIANNESS_LITTLE_ENDIAN ? 0 : 2, 2),
            $endianness
        );
    }
}