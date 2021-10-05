<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type\IntegerTypeInterface;
use Kryus\Binary\Value\Int\SignedValueInterface;
use Kryus\Binary\Value\Int\UnsignedValueInterface;

interface IntegerValueInterface extends NumericValueInterface
{
    /**
     * @return IntegerTypeInterface
     */
    public function getType(): IntegerTypeInterface;

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