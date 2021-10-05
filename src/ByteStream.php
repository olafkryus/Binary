<?php
declare(strict_types=1);

namespace Kryus\Binary;

use Kryus\Binary\Type;
use Kryus\Binary\Value;
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
     * @return Value\Int\Byte
     * @throws \Exception
     */
    public function readByte(?int $endianness = null): Value\Int\Byte
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new Value\Int\Byte($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Value\Int\UnsignedByte
     * @throws \Exception
     */
    public function readUnsignedByte(?int $endianness = null): Value\Int\UnsignedByte
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(1);

        return new Value\Int\UnsignedByte($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Value\Int\Word
     * @throws \Exception
     */
    public function readWord(?int $endianness = null): Value\Int\Word
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new Value\Int\Word($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Value\Int\UnsignedWord
     * @throws \Exception
     */
    public function readUnsignedWord(?int $endianness = null): Value\Int\UnsignedWord
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(2);

        return new Value\Int\UnsignedWord($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Value\Int\Dword
     * @throws \Exception
     */
    public function readDword(?int $endianness = null): Value\Int\Dword
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new Value\Int\Dword($binaryValue, $endianness);
    }

    /**
     * @param int|null $endianness
     * @return Value\Int\UnsignedDword
     * @throws \Exception
     */
    public function readUnsignedDword(?int $endianness = null): Value\Int\UnsignedDword
    {
        $endianness = $endianness ?? $this->endianness;
        if (!Endianness::isValid($endianness)) {
            throw new \Exception('Invalid endianness type.');
        }

        $binaryValue = $this->readBytes(4);

        return new Value\Int\UnsignedDword($binaryValue, $endianness);
    }
}
