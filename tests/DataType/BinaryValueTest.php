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

    /**
     * @dataProvider intValueTestProvider
     */
    public function testDoesReturnCorrectIntValue(
        string $value,
        int $endianness,
        bool $signed,
        int $expectedValue
    ): void {
        $value = new BinaryValue($value, $endianness, $signed);

        self::assertSame($expectedValue, $value->toInt());
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

    public function intValueTestProvider(): array
    {
        $x80 = chr(0x80);
        $x8081 = chr(0x80) . chr(0x81);
        $x00008081 = chr(0x00) . chr(0x00) . chr(0x80) . chr(0x81);

        return [
            '1-byte little endian signed' => [$x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, true, -0x7F - 1],
            '1-byte big endian signed' => [$x80, Endianness::ENDIANNESS_BIG_ENDIAN, true, -0x7F - 1],
            '1-byte little endian unsigned' => [$x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, false, 0x80],
            '1-byte big endian unsigned' => [$x80, Endianness::ENDIANNESS_BIG_ENDIAN, false, 0x80],
            '2-byte little endian signed' => [$x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true, -0x7E7F - 1],
            '2-byte big endian signed' => [$x8081, Endianness::ENDIANNESS_BIG_ENDIAN, true, -0x7F7E - 1],
            '2-byte little endian unsigned' => [$x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false, 0x8180],
            '2-byte big endian unsigned' => [$x8081, Endianness::ENDIANNESS_BIG_ENDIAN, false, 0x8081],
            '4-byte little endian signed' => [$x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true, -0x7E7FFFFF - 1],
            '4-byte big endian signed' => [$x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, true, 0x00008081],
            '4-byte little endian unsigned' => [$x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false, 0x81800000],
            '4-byte big endian unsigned' => [$x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, false, 0x00008081],
        ];
    }
}