<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType;

class Dword extends BinaryValue
{
    /**
     * @param string $value
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct(string $value, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        $byteCount = strlen($value);
        if ($byteCount !== 4) {
            throw new \Exception("Invalid byte count of {$byteCount} for value of type Dword.");
        }

        parent::__construct($value, $endianness);
    }

    /**
     * @return Word
     * @throws \Exception
     */
    public function getHighWord(): Word
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new Word(substr($value, $endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 2 : 0, 2), $endianness);
    }

    /**
     * @return Word
     * @throws \Exception
     */
    public function getLowWord(): Word
    {
        $value = $this->__toString();
        $endianness = $this->getEndianness();

        return new Word(substr($value, $endianness === BinaryValue::ENDIANNESS_LITTLE_ENDIAN ? 0 : 2, 2), $endianness);
    }
}