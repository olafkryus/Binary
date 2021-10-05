<?php
declare(strict_types=1);

namespace Kryus\Binary\Value;

interface BinaryValueInterface
{
    /**
     * @return int
     */
    public function getByteCount(): int;

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
    public function __toString();
}