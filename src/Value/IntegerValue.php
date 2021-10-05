<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\Int\SignedValueInterface;
use Kryus\Binary\Value\Int\UnsignedValueInterface;

class IntegerValue extends NumericValue implements IntegerValueInterface
{
    /** @var bool */
    private $signed;

    /**
     * @param string $value
     * @param int $endianness
     * @param bool $signed
     * @throws \Exception
     */
    public function __construct(
        string $value,
        int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN,
        bool $signed = true
    ) {
        parent::__construct($value, $endianness);

        $this->signed = $signed;
    }

    /**
     * @return SignedValueInterface
     * @throws \Exception
     */
    public function toSigned(): SignedValueInterface
    {
        $value = $this->asSigned();

        if ($value->toInt() < 0) {
            throw new \Exception("Value too big for type.");
        }

        return $value;
    }

    /**
     * @return SignedValueInterface
     */
    public function asSigned(): SignedValueInterface
    {
        return new self($this->__toString(), $this->getEndianness(), true);
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        $value = 0;

        $byteCount = $this->getType()->getByteCount();
        $bytes = array_map(
            'ord',
            str_split($this->__toString())
        );

        $endianness = $this->getEndianness();
        $isSigned = $this->getType()->signed();

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

    public function getType(): Type\IntegerTypeInterface
    {
        $parentType = parent::getType();
        $byteCount = $parentType->getByteCount();

        return new Type\IntegerType($byteCount, $this->signed);
    }

    /**
     * @return UnsignedValueInterface
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedValueInterface
    {
        if ($this->isNegative()) {
            throw new \Exception("Value too small for type.");
        }

        return $this->asUnsigned();
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return $this->toInt() < 0;
    }

    /**
     * @return UnsignedValueInterface
     */
    public function asUnsigned(): UnsignedValueInterface
    {
        return new self($this->__toString(), $this->getEndianness(), false);
    }
}