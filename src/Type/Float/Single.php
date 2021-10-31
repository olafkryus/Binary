<?php

declare(strict_types=1);

namespace Kryus\Binary\Type\Float;

use Attribute;
use Kryus\Binary\Type\FloatingPointType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Single extends FloatingPointType
{
    private const BYTE_COUNT = 4;
    private const EXPONENT_BIT_COUNT = 8;
    private const SIGNIFICAND_BIT_COUNT = 23;
    private const EXPONENT_BIAS = 127;

    public function __construct()
    {
        parent::__construct(
            self::BYTE_COUNT,
            self::EXPONENT_BIT_COUNT,
            self::SIGNIFICAND_BIT_COUNT,
            self::EXPONENT_BIAS
        );
    }
}