<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type\FloatingPointTypeInterface;

class FloatingPointValue extends NumericValue implements FloatingPointValueInterface
{
    /** @var FloatingPointTypeInterface */
    private FloatingPointTypeInterface $type;

    /**
     * @param FloatingPointTypeInterface $type
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(
        FloatingPointTypeInterface $type,
        string $value,
        int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN
    ) {
        parent::__construct($type, $value, $endianness);
        $this->type = $type;
    }

    /**
     * @return FloatingPointTypeInterface
     */
    public function getType(): FloatingPointTypeInterface
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        // TODO: Implement isNegative() method.
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        // TODO: Implement toFloat() method.
    }
}