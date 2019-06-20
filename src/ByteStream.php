<?php
declare(strict_types=1);

namespace Kryus\Binary;

use Kryus\Binary\DataType\BinaryValue;
use Kryus\Binary\DataType\Byte;
use Kryus\Binary\DataType\Dword;
use Kryus\Binary\DataType\SignedByte;
use Kryus\Binary\DataType\SignedDword;
use Kryus\Binary\DataType\SignedWord;
use Kryus\Binary\DataType\Word;

class ByteStream
{
    /** @var resource */
    private $handle;

    /** @var bool */
    private $internalHandle = false;

    /** @var int */
    private $cursor = 0;

    /** @var int */
    private $endianness;

    /**
     * @param resource $handle
     * @param int $endianness
     * @throws \Exception
     */
    public function __construct($handle, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN)
    {
        if (!in_array($endianness, [BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $this->handle = $handle;
        $this->endianness = $endianness;
    }

    public function __destruct()
    {
        if ($this->internalHandle) {
            $this->close();
        }
    }

    /**
     * @param string $filename
     * @param string $mode
     * @param int $endianness
     * @return ByteStream
     * @throws \Exception
     */
    public static function createFromFilename(string $filename, string $mode, int $endianness = BinaryValue::ENDIANNESS_LITTLE_ENDIAN): ByteStream
    {
        $handle = fopen($filename, $mode);

        $stream = new self($handle, $endianness);
        $stream->internalHandle = true;

        return $stream;
    }

    /**
     * @return bool
     */
    public function isEof(): bool
    {
        return feof($this->handle);
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return fclose($this->handle);
    }

    /**
     * @param int $count
     * @return string
     * @throws \Exception
     */
    public function readBytes(int $count): string
    {
        if ($this->isEof()) {
            throw new \Exception("Cannot read value: End of stream reached at position {$this->cursor}.");
        }

        $value = fread($this->handle, $count);
        $this->cursor += $count;

        if (strlen($value) !== $count) {
            throw new \Exception("Cannot read value: Unexpected end of stream at position {$this->cursor}.");
        }

        return $value;
    }

    /**
     * @param int $maxLength
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public function readString(int $maxLength, string $encoding = 'UTF-8'): string
    {
        $string = $this->readBytes($maxLength);

        $stringTerminatorPosition = strpos($string, chr(0));
        if ($stringTerminatorPosition !== false) {
            $trimmedString = substr($string, 0, $stringTerminatorPosition);
        } else {
            $trimmedString = substr($string, 0);
        }

        if ($encoding === 'UTF-8') {
            return $trimmedString;
        }

        return mb_convert_encoding($trimmedString, 'UTF-8', $encoding);
    }

    /**
     * @param int|null $endianness
     * @return Byte
     * @throws \Exception
     */
    public function readByte(?int $endianness = null): Byte
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new Byte($binaryValue, $endianness ?? $this->endianness);
    }

    /**
     * @param int|null $endianness
     * @return SignedByte
     * @throws \Exception
     */
    public function readSignedByte(?int $endianness = null): SignedByte
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new SignedByte($binaryValue, $endianness ?? $this->endianness);
    }

    /**
     * @param int|null $endianness
     * @return Word
     * @throws \Exception
     */
    public function readWord(?int $endianness = null): Word
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new Word($binaryValue, $endianness ?? $this->endianness);
    }

    /**
     * @param int|null $endianness
     * @return SignedWord
     * @throws \Exception
     */
    public function readSignedWord(?int $endianness = null): SignedWord
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new SignedWord($binaryValue, $endianness ?? $this->endianness);
    }

    /**
     * @param int|null $endianness
     * @return Dword
     * @throws \Exception
     */
    public function readDword(?int $endianness = null): Dword
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new Dword($binaryValue, $endianness ?? $this->endianness);
    }

    /**
     * @param int|null $endianness
     * @return SignedDword
     * @throws \Exception
     */
    public function readSignedDword(?int $endianness = null): SignedDword
    {
        if (!in_array($endianness, [null, BinaryValue::ENDIANNESS_LITTLE_ENDIAN, BinaryValue::ENDIANNESS_BIG_ENDIAN], true)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new SignedDword($binaryValue, $endianness ?? $this->endianness);
    }
}
