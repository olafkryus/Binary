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
     * @return bool
     */
    public function isNegative(): bool
    {
        // TODO: Implement isNegative() method.
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        // TODO: Implement toFloat() method.
    }
}