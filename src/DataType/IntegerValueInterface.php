<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

interface IntegerValueInterface extends NumericValueInterface
{
    /**
     * @return int
     */
    public function toInt(): int;
}