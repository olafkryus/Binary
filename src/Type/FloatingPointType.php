<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class FloatingPointType extends NumericType implements FloatingPointTypeInterface
{
    private const IS_SIGNED = true;

    public function __construct(int $byteCount)
    {
        parent::__construct($byteCount, self::IS_SIGNED);
    }
}