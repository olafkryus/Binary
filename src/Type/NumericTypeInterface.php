<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

interface NumericTypeInterface extends BinaryTypeInterface
{
    /**
     * @return bool
     */
    public function signed(): bool;
}