<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type\NumericTypeInterface;

interface NumericValueInterface extends BinaryValueInterface
{
    /**
     * @return NumericTypeInterface
     */
    public function getType(): NumericTypeInterface;

    /**
     * @return int
     */
    public function getEndianness(): int;

    /**
     * @return static
     */
    public function toLittleEndian(): static;

    /**
     * @return static
     */
    public function asLittleEndian(): static;

    /**
     * @return static
     */
    public function toBigEndian(): static;

    /**
     * @return static
     */
    public function asBigEndian(): static;

    /**
     * @return bool
     */
    public function isNegative(): bool;
}