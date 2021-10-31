<?php

declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Type\BinaryTypeInterface;

class BinaryValue implements BinaryValueInterface
{
    /** @var BinaryTypeInterface  */
    private BinaryTypeInterface $type;

    /** @var int[] */
    private array $value;

    /**
     * @param BinaryTypeInterface $type
     * @param string $value
     */
    public function __construct(
        BinaryTypeInterface $type,
        string $value
    ) {
        $this->type = $type;
        $this->value = array_map(
            'ord',
            str_split($value)
        );
    }

    public function getType(): BinaryTypeInterface
    {
        return $this->type;
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
    public function __toString(): string
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