<?php

declare(strict_types=1);

namespace Kryus\Binary\Value\Int;

use Kryus\Binary\Value\IntegerValueInterface;

interface ByteInterface extends IntegerValueInterface
{
    public const BYTE_COUNT = 1;

    /**
     * @return Byte
     */
    public function asSigned(): Byte;

    /**
     * @return Byte
     * @throws \Exception
     */
    public function toSigned(): Byte;

    /**
     * @return UnsignedByte
     */
    public function asUnsigned(): UnsignedByte;

    /**
     * @return UnsignedByte
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedByte;
}