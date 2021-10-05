<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type;

class FloatingPointValue extends NumericValue implements FloatingPointValueInterface
{
    public function getType(): Type\FloatingPointTypeInterface
    {
        $parentType = parent::getType();
        $byteCount = $parentType->getByteCount();

        return new Type\FloatingPointType($byteCount);
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