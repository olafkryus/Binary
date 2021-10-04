<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

use Kryus\Binary\DataType\IntegerValueInterface;

interface SignedValueInterface extends IntegerValueInterface
{
    public const IS_SIGNED = true;
}