<?php
declare(strict_types=1);

namespace Kryus\Binary\Value;

use Kryus\Binary\Enum\Endianness;

abstract class NumericValue extends BinaryValue implements NumericValueInterface
{
    /** @var int */
    private $endianness;

    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        parent::__construct($value);

        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $this->endianness = $endianness;
    }

    /**
     * @return int
     */
    public function getEndianness(): int
    {
        return $this->endianness;
    }

    /**
     * @return bool
     */
    abstract public function isSigned(): bool;

    /**
     * @return bool
     */
    abstract public function isNegative(): bool;
}