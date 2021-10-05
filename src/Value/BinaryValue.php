<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type;

class BinaryValue implements BinaryValueInterface
{
    /** @var int[] */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = array_map(
            'ord',
            str_split($value)
        );
    }

    public function getType(): Type\BinaryTypeInterface
    {
        $byteCount = count($this->value);

        return new Type\BinaryType($byteCount);
    }

    /**
     * @return string
     */
    public function toHex(): string
    {
        return implode(
            '',
            array_map(
                static function ($value) {
                    return str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
                },
                $this->value
            )
        );
    }

    /**
     * @return string
     */
    public function toBin(): string
    {
        return implode(
            '',
            array_map(
                static function ($value) {
                    return str_pad(decbin($value), 8, '0', STR_PAD_LEFT);
                },
                $this->value
            )
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(
            '',
            array_map(
                'chr',
                $this->value
            )
        );
    }
}