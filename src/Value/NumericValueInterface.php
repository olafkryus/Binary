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
     * @return bool
     */
    public function isNegative(): bool;
}