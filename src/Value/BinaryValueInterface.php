<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type\BinaryTypeInterface;

interface BinaryValueInterface
{
    /**
     * @return BinaryTypeInterface
     */
    public function getType(): BinaryTypeInterface;

    /**
     * @return string
     */
    public function toHex(): string;

    /**
     * @return string
     */
    public function toBin(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}