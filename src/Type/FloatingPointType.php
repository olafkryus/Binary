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
    private int $exponentBias;

    public function __construct(int $byteCount, int $exponentBitCount, int $significandBitCount, int $exponentBias)
    {
        parent::__construct($byteCount, self::IS_SIGNED);
        $this->exponentBitCount = $exponentBitCount;
        $this->significandBitCount = $significandBitCount;
        $this->exponentBias = $exponentBias;
    }

    public function getExponentBitCount(): int
    {
        return $this->exponentBitCount;
    }

    public function getSignificandBitCount(): int
    {
        return $this->significandBitCount;
    }

    public function getExponentBias(): int
    {
        return $this->exponentBias;
    }
}