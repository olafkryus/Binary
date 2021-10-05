<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

interface BinaryTypeInterface
{
    /**
     * @return int
     */
    public function getByteCount(): int;
}