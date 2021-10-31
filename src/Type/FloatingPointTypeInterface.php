<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

interface FloatingPointTypeInterface extends NumericTypeInterface
{
    /**
     * @return int
     */
    public function getExponentBitCount(): int;

    /**
     * @return int
     */
    public function getSignificandBitCount(): int;
}