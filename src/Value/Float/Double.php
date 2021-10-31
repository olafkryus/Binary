<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Float;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type;
use Kryus\Binary\Value\FloatingPointValue;

/**
 * TODO: Stub
 */
class Double extends FloatingPointValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(
        string $value,
        int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN
    ) {
        parent::__construct($this->getType(), $value, $endianness);
    }

    public function getType(): Type\Float\Double
    {
        return new Type\Float\Double();
    }
}