<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\DataType;

use Kryus\Binary\DataType\IntegerValue;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class IntegerValueTest extends TestCase
{
    /**
     * @dataProvider signednessProvider
     */
    public function testDoesReturnCorrectSignedness(bool $signedness): void
    {
        $value = new IntegerValue(' ', Endianness::ENDIANNESS_LITTLE_ENDIAN, $signedness);

        self::assertSame($signedness, $value->isSigned());
    }

    /**
     * @dataProvider endiannessProvider
     */
    public function testDoesReturnCorrectEndianness(int $endianness): void
    {
        $value = new IntegerValue(' ', $endianness);

        self::assertSame($endianness, $value->getEndianness());
    }

    public function testCannotInstantiateWithInvalidEndianness(): void
    {
        $this->expectException(\Exception::class);

        new IntegerValue(' ', 2);
    }

    /**
     * @dataProvider intValueTestProvider
     */
    public function testDoesReturnCorrectIntValue(IntegerValue $value, int $expectedValue): void
    {
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

    private function getValueTestSet(): array
    {
        $x80 = chr(0x80);
        $x8081 = chr(0x80) . chr(0x81);
        $x00008081 = chr(0x00) . chr(0x00) . chr(0x80) . chr(0x81);

        return [
            '1-byte little endian signed' => new IntegerValue($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '1-byte big endian signed' => new IntegerValue($x80, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '1-byte little endian unsigned' => new IntegerValue($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '1-byte big endian unsigned' => new IntegerValue($x80, Endianness::ENDIANNESS_BIG_ENDIAN, false),
            '2-byte little endian signed' => new IntegerValue($x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '2-byte big endian signed' => new IntegerValue($x8081, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '2-byte little endian unsigned' => new IntegerValue($x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '2-byte big endian unsigned' => new IntegerValue($x8081, Endianness::ENDIANNESS_BIG_ENDIAN, false),
            '4-byte little endian signed' => new IntegerValue($x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, true),
            '4-byte big endian signed' => new IntegerValue($x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, true),
            '4-byte little endian unsigned' => new IntegerValue($x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN, false),
            '4-byte big endian unsigned' => new IntegerValue($x00008081, Endianness::ENDIANNESS_BIG_ENDIAN, false),
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
}