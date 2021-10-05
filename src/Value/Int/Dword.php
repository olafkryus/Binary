<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\IntegerValue;

class Dword extends IntegerValue implements DwordInterface, SignedValueInterface
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
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Dword.");
        }

        parent::__construct($value, $endianness, self::IS_SIGNED);
    }

    public function getType(): Type\IntegerTypeInterface
    {
        return new Type\Int\Dword();
    }

    /**
     * @return Dword
     */
    public function asSigned(): Dword
    {
        return clone $this;
    }

    /**
     * @return Dword
     */
    public function toSigned(): Dword
    {
        return clone $this;
    }

    /**
     * @return UnsignedDword
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedDword
    {
        if ($this->isNegative()) {
            throw new \Exception("Value too small for type Unsigned Dword.");
        }

        return $this->asUnsigned();
    }

    /**
     * @return UnsignedDword
     * @throws \Exception
     */
    public function asUnsigned(): UnsignedDword
    {
        return new UnsignedDword($this->__toString(), $this->getEndianness());
    }
}