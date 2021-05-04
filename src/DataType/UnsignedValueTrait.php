<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

trait UnsignedValueTrait
{
    /**
     * @return static
     */
    public function asUnsigned()
    {
        return clone $this;
    }

    /**
     * @return static
     */
    public function toUnsigned()
    {
        return clone $this;
    }
}