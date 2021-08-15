<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

use Kryus\Binary\Enum\Endianness;

class NumericValue extends BinaryValue
{
    /** @var int */
    private $endianness;

    /** @var bool */
    private $signed;

    /**
     * @param string $value
     * @param int $endianness
     * @param bool $signed
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN, bool $signed = true)
    {
        parent::__construct($value);

        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $this->endianness = $endianness;
        $this->signed = $signed;
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
    public function isSigned(): bool
    {
        return $this->signed;
    }
}