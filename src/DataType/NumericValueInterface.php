<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

interface NumericValueInterface extends BinaryValueInterface
{
    /**
     * @return int
     */
    public function getEndianness(): int;

    /**
     * @return bool
     */
    public function isSigned(): bool;
}