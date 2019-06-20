<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class BinaryValue
{
    public const ENDIANNESS_LITTLE_ENDIAN = 0;
    public const ENDIANNESS_BIG_ENDIAN = 1;

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
    public function __construct(string $value, int $endianness = self::ENDIANNESS_LITTLE_ENDIAN, bool $signed = false)
    {
        if (!in_array($endianness, [self::ENDIANNESS_LITTLE_ENDIAN, self::ENDIANNESS_BIG_ENDIAN], true)) {
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
    public function toInt(): int
    {
        $value = 0;
        $byteCount = count($this->value);

        if ($this->endianness === self::ENDIANNESS_BIG_ENDIAN) {
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