<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class NumericValue extends BinaryValue
{
    /** @var int */
    private $endianness;

    /** @var bool */
    private $signed;

    /**
     * @param string $value
     * @param int $endianness
     * @param bool $signed
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN, bool $signed = true)
    {
        parent::__construct($value);

        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $this->endianness = $endianness;
        $this->signed = $signed;
    }

    /**
     * @return int
     */
    public function getEndianness(): int
    {
        return $this->endianness;
    }

    /**
     * @return bool
     */
    public function isSigned(): bool
    {
        return $this->signed;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        $value = 0;
        $byteCount = $this->getByteCount();
        $bytes = array_map(
            'ord',
            str_split($this->__toString())
        );

        if ($this->endianness === Endianness::ENDIANNESS_BIG_ENDIAN) {
            for ($i = 0; $i < $byteCount; ++$i) {
                $value *= 256;
                $value += $bytes[$i];
            }
        } else {
            for ($i = $byteCount - 1; $i >= 0; --$i) {
                $value *= 256;
                $value += $bytes[$i];
            }
        }

        if ($this->signed) {
            $maxSignedValue = (1 << (8 * $byteCount - 1)) - 1;

            if ($value > $maxSignedValue) {
                $value -= ($maxSignedValue + 1) * 2;
            }
        }

        return $value;
    }
}