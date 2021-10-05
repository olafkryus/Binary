<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type\FloatingPointTypeInterface;

interface FloatingPointValueInterface extends NumericValueInterface
{
    /**
     * @return FloatingPointTypeInterface
     */
    public function getType(): FloatingPointTypeInterface;

    /**
     * @return float
     */
    public function toFloat(): float;
}