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
    public function testDoesReturnCorrectIntValue(BinaryValue $value, int $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toInt());
    }

    /**
     * @dataProvider hexValueTestProvider
     */
    public function testDoesReturnCorrectHexValue(BinaryValue $value, string $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toHex());
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

    private function getValueTestSet(): array
    {
        $x80 = chr(0x80);
        $x8081 = chr(0x80) . chr(0x81);
        $x00008081 = chr(0x00) . chr(0x00) . chr(0x80) . chr(0x81);

        return [
            '1-byte little endian signed' => new BinaryValue($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '1-byte big endian signed' => new BinaryValue($x80, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '1-byte little endian unsigned' => new BinaryValue($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '1-byte big endian unsigned' => new BinaryValue($x80, Endianness::ENDIANNESS_BIG_ENDIAN, false),
            '2-byte little endian signed' => new BinaryValue($x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '2-byte big endian signed' => new BinaryValue($x8081, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '2-byte little endian unsigned' => new BinaryValue($x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '2-byte big endian unsigned' => new BinaryValue($x8081, Endianness::ENDIANNESS_BIG_ENDIAN, false),
            '4-byte little endian signed' => new BinaryValue($x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '4-byte big endian signed' => new BinaryValue($x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '4-byte little endian unsigned' => new BinaryValue($x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '4-byte big endian unsigned' => new BinaryValue($x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, false),
        ];
    }

    public function intValueTestProvider(): array
    {
        $values = $this->getValueTestSet();

        $expectedValues = [
            '1-byte little endian signed' => -0x7F - 1,
            '1-byte big endian signed' => -0x7F - 1,
            '1-byte little endian unsigned' => 0x80,
            '1-byte big endian unsigned' => 0x80,
            '2-byte little endian signed' => -0x7E7F - 1,
            '2-byte big endian signed' => -0x7F7E - 1,
            '2-byte little endian unsigned' => 0x8180,
            '2-byte big endian unsigned' => 0x8081,
            '4-byte little endian signed' => -0x7E7FFFFF - 1,
            '4-byte big endian signed' => 0x00008081,
            '4-byte little endian unsigned' => 0x81800000,
            '4-byte big endian unsigned' => 0x00008081,
        ];

        return array_map(
            static function ($value, $key) use ($expectedValues) {
                return [$value, $expectedValues[$key]];
            },
            $values,
            array_keys($values)
        );
    }

    public function hexValueTestProvider(): array
    {
        $values = $this->getValueTestSet();

        $_80 = '80';
        $_8081 = '8081';
        $_00008081 = '00008081';

        $expectedValues = [
            '1-byte little endian signed' => $_80,
            '1-byte big endian signed' => $_80,
            '1-byte little endian unsigned' => $_80,
            '1-byte big endian unsigned' => $_80,
            '2-byte little endian signed' => $_8081,
            '2-byte big endian signed' => $_8081,
            '2-byte little endian unsigned' => $_8081,
            '2-byte big endian unsigned' => $_8081,
            '4-byte little endian signed' => $_00008081,
            '4-byte big endian signed' => $_00008081,
            '4-byte little endian unsigned' => $_00008081,
            '4-byte big endian unsigned' => $_00008081,
        ];

        return array_map(
            static function ($value, $key) use ($expectedValues) {
                return [$value, $expectedValues[$key]];
            },
            $values,
            array_keys($values)
        );
    }
}