<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class FloatingPointType extends NumericType implements FloatingPointTypeInterface
{
    private const IS_SIGNED = true;

    private int $exponentBitCount;
    private int $significandBitCount;

    public function __construct(int $byteCount, int $exponentBitCount, int $significandBitCount)
    {
        parent::__construct($byteCount, self::IS_SIGNED);
        $this->exponentBitCount = $exponentBitCount;
        $this->significandBitCount = $significandBitCount;
    }

    public function getExponentBitCount(): int
    {
        return $this->exponentBitCount;
    }

    public function getSignificandBitCount(): int
    {
        return $this->significandBitCount;
    }
}