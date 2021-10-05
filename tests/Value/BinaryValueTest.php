<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Value\BinaryValue;
use Kryus\Binary\Value\IntegerValue;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class BinaryValueTest extends TestCase
{
    /**
     * @dataProvider hexValueTestProvider
     */
    public function testDoesReturnCorrectHexValue(BinaryValue $value, string $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toHex());
    }

    /**
     * @dataProvider binValueTestProvider
     */
    public function testDoesReturnCorrectBinValue(BinaryValue $value, string $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toBin());
    }

    /**
     * @dataProvider stringValueTestProvider
     */
    public function testDoesReturnCorrectStringValue(BinaryValue $value, string $expectedValue): void
    {
        self::assertSame($expectedValue, (string)$value);
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

    public function binValueTestProvider(): array
    {
        $values = $this->getValueTestSet();

        $_80 = '10000000';
        $_8081 = '10000000' . '10000001';
        $_00008081 = '00000000' . '00000000' . '10000000' . '10000001';

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

    public function stringValueTestProvider(): array
    {
        $values = $this->getValueTestSet();

        $x80 = chr(0x80);
        $x8081 = chr(0x80) . chr(0x81);
        $x00008081 = chr(0x00) . chr(0x00) . chr(0x80) . chr(0x81);

        $expectedValues = [
            '1-byte little endian signed' => $x80,
            '1-byte big endian signed' => $x80,
            '1-byte little endian unsigned' => $x80,
            '1-byte big endian unsigned' => $x80,
            '2-byte little endian signed' => $x8081,
            '2-byte big endian signed' => $x8081,
            '2-byte little endian unsigned' => $x8081,
            '2-byte big endian unsigned' => $x8081,
            '4-byte little endian signed' => $x00008081,
            '4-byte big endian signed' => $x00008081,
            '4-byte little endian unsigned' => $x00008081,
            '4-byte big endian unsigned' => $x00008081,
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