<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\DataType;

use Kryus\Binary\DataType\BinaryValue;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class BinaryValueTest extends TestCase
{
    /**
     * @dataProvider signednessProvider
     */
    public function testDoesReturnCorrectSignedness(bool $signedness): void
    {
        $value = new BinaryValue(' ', Endianness::ENDIANNESS_LITTLE_ENDIAN, $signedness);

        self::assertSame($signedness, $value->isSigned());
    }

    /**
     * @dataProvider endiannessProvider
     */
    public function testDoesReturnCorrectEndianness(int $endianness): void
    {
        $value = new BinaryValue(' ', $endianness);

        self::assertSame($endianness, $value->getEndianness());
    }

    public function testCannotInstantiateWithInvalidEndianness(): void
    {
        $this->expectException(\Exception::class);

        new BinaryValue(' ', 2);
    }

    public function signednessProvider(): array
    {
        return [
            'signed' => [true],
            'unsigned' => [false],
        ];
    }

    public function endiannessProvider(): array
    {
        return [
            'little endian' => [Endianness::ENDIANNESS_LITTLE_ENDIAN],
            'big endian' => [Endianness::ENDIANNESS_BIG_ENDIAN],
        ];
    }
}