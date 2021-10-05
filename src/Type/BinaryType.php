<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class BinaryType implements BinaryTypeInterface
{
    private int $byteCount;

    public function __construct(int $byteCount)
    {
        $this->byteCount = $byteCount;
    }

    public function getByteCount(): int
    {
        return $this->byteCount;
    }
}