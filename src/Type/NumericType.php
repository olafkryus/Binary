<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
abstract class NumericType extends BinaryType implements NumericTypeInterface
{
    private bool $signed;

    public function __construct(int $byteCount, bool $signed)
    {
        $this->signed = $signed;
        parent::__construct($byteCount);
    }

    public function signed(): bool
    {
        return $this->signed;
    }
}