<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

trait SignedValueTrait
{
    /**
     * @return SignedValueInterface
     */
    public function asSigned(): SignedValueInterface
    {
        return clone $this;
    }

    /**
     * @return SignedValueInterface
     */
    public function toSigned(): SignedValueInterface
    {
        return clone $this;
    }
}