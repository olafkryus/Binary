<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class FloatingPointValue extends NumericValue implements FloatingPointValueInterface
{
    /**
     * @return bool
     */
    public function isSigned(): bool
    {
        return true;
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        // TODO: Implement toFloat() method.
    }
}