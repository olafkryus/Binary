<?php
declare(strict_types=1);

namespace Kryus\Binary\DataType\Int;

use Kryus\Binary\DataType\IntegerValueInterface;

interface WordInterface extends IntegerValueInterface
{
    public const BYTE_COUNT = 2;

    /**
     * @return Word
     */
    public function asSigned(): Word;

    /**
     * @return Word
     * @throws \Exception
     */
    public function toSigned(): Word;

    /**
     * @return UnsignedWord
     */
    public function asUnsigned(): UnsignedWord;

    /**
     * @return UnsignedWord
     * @throws \Exception
     */
    public function toUnsigned(): UnsignedWord;
}