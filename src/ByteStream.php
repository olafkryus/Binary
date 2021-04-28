<?php
declare(strict_types=1);

namespace Kryus\Binary;

use Kryus\Binary\DataType\Byte;
use Kryus\Binary\DataType\Dword;
use Kryus\Binary\DataType\UnsignedByte;
use Kryus\Binary\DataType\UnsignedDword;
use Kryus\Binary\DataType\UnsignedWord;
use Kryus\Binary\DataType\Word;
use Kryus\Binary\Enum\Endianness;

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
    public function __construct($handle, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN)
    {
        if (!Endianness::isValid($endianness)) {
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
    public static function createFromFilename(string $filename, string $mode, int $endianness = Endianness::ENDIANNESS_LITTLE_ENDIAN): ByteStream
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
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new Byte($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return UnsignedByte
     * @throws \Exception
     */
    public function readUnsignedByte(?int $endianness = null): UnsignedByte
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new UnsignedByte($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Word
     * @throws \Exception
     */
    public function readWord(?int $endianness = null): Word
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new Word($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return UnsignedWord
     * @throws \Exception
     */
    public function readUnsignedWord(?int $endianness = null): UnsignedWord
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new UnsignedWord($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Dword
     * @throws \Exception
     */
    public function readDword(?int $endianness = null): Dword
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new Dword($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return UnsignedDword
     * @throws \Exception
     */
    public function readUnsignedDword(?int $endianness = null): UnsignedDword
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new UnsignedDword($binaryValue, $endianness);
    }
}
