<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type\NumericTypeInterface;

abstract class NumericValue extends BinaryValue implements NumericValueInterface
{
    /** @var NumericTypeInterface */
    private NumericTypeInterface $type;

    /** @var int */
    private int $endianness;

    /**
     * @param NumericTypeInterface $type
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(
        NumericTypeInterface $type,
        string $value,
        int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN
    ) {
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        parent::__construct($type, $value);
        $this->type = $type;
        $this->endianness = $endianness;
    }

    /**
     * @return NumericTypeInterface
     */
    public function getType(): NumericTypeInterface
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getEndianness(): int
    {
        return $this->endianness;
    }

    /**
     * @return static
     */
    public function toLittleEndian(): static
    {
        if ($this->getEndianness() === Endianness::ENDIANNESS_LITTLE_ENDIAN) {
            return clone $this;
        }

        $bytes = array_map(
            'ord',
            str_split($this->__toString())
        );
        $reversedBytes = array_reverse($bytes);
        $littleEndianValue = implode(
            '',
            array_map(
                'chr',
                $reversedBytes
            )
        );

        return new static(
            $this->getType(),
            $littleEndianValue,
            Endianness::ENDIANNESS_LITTLE_ENDIAN
        );
    }

    /**
     * @return static
     */
    public function asLittleEndian(): static
    {
        return new static(
            $this->getType(),
            $this->__toString(),
            Endianness::ENDIANNESS_LITTLE_ENDIAN
        );
    }

    /**
     * @return static
     */
    public function toBigEndian(): static
    {
        if ($this->getEndianness() === Endianness::ENDIANNESS_BIG_ENDIAN) {
            return clone $this;
        }

        $bytes = array_map(
            'ord',
            str_split($this->__toString())
        );
        $reversedBytes = array_reverse($bytes);
        $bigEndianValue = implode(
            '',
            array_map(
                'chr',
                $reversedBytes
            )
        );

        return new static(
            $this->getType(),
            $bigEndianValue,
            Endianness::ENDIANNESS_BIG_ENDIAN
        );
    }

    /**
     * @return static
     */
    public function asBigEndian(): static
    {
        return new static(
            $this->getType(),
            $this->__toString(),
            Endianness::ENDIANNESS_BIG_ENDIAN
        );
    }

    /**
     * @return bool
     */
    abstract public function isNegative(): bool;
}