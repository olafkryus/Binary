<?php
declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Value\IntegerValue;
use Kryus\Binary\Enum\Endianness;

class Word extends IntegerValue implements WordInterface, SignedValueInterface
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
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Word.");
        }

        parent::__construct($value, $endianness, self::IS_SIGNED);
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function asUnsigned(): UnsignedWord
    {
        return new UnsignedWord($this->__toString(), $this->getEndianness());
    }

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedWord
    {
        if ($this->isNegative()) {
            throw new \Exception("Value too small for type Unsigned Word.");
        }

        return $this->asUnsigned();
    }
}