<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Float;

use Kryus\Binary\Type;
use Kryus\Binary\Value\FloatingPointValue;

/**
 * TODO: Stub
 */
class Double extends FloatingPointValue
{
    public function getType(): Type\FloatingPointTypeInterface
    {
        return new Type\Float\Double();
    }
}