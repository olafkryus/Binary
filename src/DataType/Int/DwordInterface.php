<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

use Kryus\Binary\DataType\IntegerValueInterface;

interface DwordInterface extends IntegerValueInterface
{
    public const BYTE_COUNT = 4;

    /**
     * @return Dword
     */
    public function asSigned(): Dword;

    /**
     * @return Dword
     * @throws \Exception
     */
    public function toSigned(): Dword;

    /**
     * @return UnsignedDword
     */
    public function asUnsigned(): UnsignedDword;

    /**
     * @return UnsignedDword
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedDword;
}