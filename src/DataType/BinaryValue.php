<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class BinaryValue
{
    /** @var int[] */
    private $value;

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
        if (!in_array($endianness, [Endianness::ENDIANNESS_LITTLE_ENDIAN, Endianness::ENDIANNESS_LITTLE_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        foreach (str_split($value) as $char) {
            $this->value[] = ord($char);
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
    public function getByteCount(): int
    {
        return count($this->value);
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        $value = 0;
        $byteCount = $this->getByteCount();

        if ($this->endianness === Endianness::ENDIANNESS_BIG_ENDIAN) {
            for ($i = 0; $i < $byteCount; ++$i) {
                $value *= 256;
                $value += $this->value[$i];
            }
        } else {
            for ($i = $byteCount - 1; $i >= 0; --$i) {
                $value *= 256;
                $value += $this->value[$i];
            }
        }

        if ($this->signed) {
            $maxSignedValue = (1 << (8 * $byteCount - 1)) - 1;

            if ($value > $maxSignedValue) {
                $value = ($maxSignedValue + 1) * 2 - $value;
            }
        }

        return $value;
    }

    /**
     * @return string
     */
    public function toHex(): string
    {
        return implode('', array_map(
            static function ($value) {
                return str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
            },
            $this->value
        ));
    }

    /**
     * @return string
     */
    public function toBin(): string
    {
        return implode('', array_map(
            static function ($value) {
                return str_pad(decbin($value), 8, '0', STR_PAD_LEFT);
            },
            $this->value
        ));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode('', array_map(
            'chr',
            $this->value
        ));
    }
}