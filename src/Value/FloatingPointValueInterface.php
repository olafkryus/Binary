<?php
declare(strict_types=1);

namespace Kryus\Binary\Value;

interface FloatingPointValueInterface extends NumericValueInterface
{
    /**
     * @return float
     */
    public function toFloat(): float;
}