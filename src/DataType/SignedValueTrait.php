<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

trait SignedValueTrait
{
    /**
     * @return static
     */
    public function asSigned()
    {
        return clone $this;
    }

    /**
     * @return static
     */
    public function toSigned()
    {
        return clone $this;
    }
}