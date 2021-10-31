<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type\FloatingPointTypeInterface;

class FloatingPointValue extends NumericValue implements FloatingPointValueInterface
{
    /** @var FloatingPointTypeInterface */
    private FloatingPointTypeInterface $type;

    /**
     * @param FloatingPointTypeInterface $type
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(
        FloatingPointTypeInterface $type,
        string $value,
        int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN
    ) {
        parent::__construct($type, $value, $endianness);
        $this->type = $type;
    }

    /**
     * @return FloatingPointTypeInterface
     */
    public function getType(): FloatingPointTypeInterface
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return str_starts_with($this->toLittleEndian()->toBin(), '1');
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        if ($this->isInfinite()) {
            return $this->isNegative() ? -INF : INF;
        }
        if ($this->isNaN()) {
            return NAN;
        }

        return ($this->isNegative() ? -1 : 1) * $this->getSignificand() * 2 ** $this->getExponent();
    }

    /**
     * @return bool
     */
    public function isFinite(): bool
    {
        return $this->getExponentBin() !== str_repeat('1', $this->getType()->getExponentBitCount());
    }

    /**
     * @return bool
     */
    public function isInfinite(): bool
    {
        return
            !$this->isFinite() &&
            $this->getSignificandBin() === str_repeat('0', $this->getType()->getSignificandBitCount());
    }

    /**
     * @return bool
     */
    public function isNaN(): bool
    {
        return
            !$this->isFinite() &&
            $this->getSignificandBin() !== str_repeat('0', $this->getType()->getSignificandBitCount());
    }

    private function getExponent(): int
    {
        return bindec($this->getExponentBin()) - $this->getType()->getExponentBias();
    }

    private function getSignificand(): float
    {
        return 1 + (bindec($this->getSignificandBin()) / (1 << $this->getType()->getSignificandBitCount()));
    }

    private function getExponentBin(): string
    {
        return mb_substr(
            $this->toLittleEndian()->toBin(),
            1,
            $this->getType()->getExponentBitCount()
        );
    }

    private function getSignificandBin(): string
    {
        return
            mb_substr(
                $this->toLittleEndian()->toBin(),
                1 + $this->getType()->getExponentBitCount(),
                $this->getType()->getSignificandBitCount()
            );
    }
}