<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class IntegerValue extends NumericValue
{
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

        $endianness = $this->getEndianness();
        $isSigned = $this->isSigned();

        if ($endianness === Endianness::ENDIANNESS_BIG_ENDIAN) {
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

        if ($isSigned) {
            $maxSignedValue = (1 << (8 * $byteCount - 1)) - 1;

            if ($value > $maxSignedValue) {
                $value -= ($maxSignedValue + 1) * 2;
            }
        }

        return $value;
    }
}