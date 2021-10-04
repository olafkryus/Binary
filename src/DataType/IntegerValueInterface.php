<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\DataType\Int\SignedValueInterface;
use Kryus\Binary\DataType\Int\UnsignedValueInterface;

interface IntegerValueInterface extends NumericValueInterface
{
    /**
     * @return int
     */
    public function toInt(): int;

    /**
     * @return SignedValueInterface
     */
    public function asSigned(): SignedValueInterface;

    /**
     * @return SignedValueInterface
     * @throws \Exception
     */
    public function toSigned(): SignedValueInterface;

    /**
     * @return UnsignedValueInterface
     */
    public function asUnsigned(): UnsignedValueInterface;

    /**
     * @return UnsignedValueInterface
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedValueInterface;
}