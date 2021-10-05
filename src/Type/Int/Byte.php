<?php

declare(strict_types=1);

namespace Kryus\Binary\Type\Int;

use Attribute;
use Kryus\Binary\Type\IntegerType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Byte extends IntegerType
{
    private const BYTE_COUNT = 1;
    private const IS_SIGNED = true;

    public function __construct()
    {
        parent::__construct(self::BYTE_COUNT, self::IS_SIGNED);
    }
}