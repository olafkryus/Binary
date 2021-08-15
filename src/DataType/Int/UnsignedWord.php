<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

use Kryus\Binary\DataType\IntegerValue;
use Kryus\Binary\Enum\Endianness;

class UnsignedWord extends IntegerValue
{
    use UnsignedValueTrait;

    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 2) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Unsigned Word.");
        }

        parent::__construct($value, $endianness, false);
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