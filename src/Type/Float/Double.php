<?php

declare(strict_types=1);

namespace Kryus\Binary\Type\Float;

use Attribute;
use Kryus\Binary\Type\FloatingPointType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Double extends FloatingPointType
{
    private const BYTE_COUNT = 2;

    public function __construct()
    {
        parent::__construct(self::BYTE_COUNT);
    }
}