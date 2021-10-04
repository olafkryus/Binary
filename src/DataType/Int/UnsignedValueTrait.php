<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

trait UnsignedValueTrait
{
    /**
     * @return UnsignedValueInterface
     */
    public function asUnsigned(): UnsignedValueInterface
    {
        return clone $this;
    }

    /**
     * @return UnsignedValueInterface
     */
    public function toUnsigned(): UnsignedValueInterface
    {
        return clone $this;
    }
}