<?php

declare(strict_types=1);

namespace Kryus\Binary\Type\Int;

use Attribute;
use Kryus\Binary\Type\IntegerType;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class UnsignedWord extends IntegerType
{
    private const BYTE_COUNT = 2;
    private const IS_SIGNED = false;

    public function __construct()
    {
        parent::__construct(self::BYTE_COUNT, self::IS_SIGNED);
    }
}