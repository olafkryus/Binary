<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Type\BinaryTypeInterface;
use Kryus\Binary\Value\BinaryValue;
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
            '1-byte' => new BinaryValue($this->createType(1), $x80),
            '2-byte' => new BinaryValue($this->createType(2), $x8081),
            '4-byte' => new BinaryValue($this->createType(4), $x00008081),
        ];
    }

    public function hexValueTestProvider(): array
    {
        $values = $this->getValueTestSet();

        $_80 = '80';
        $_8081 = '8081';
        $_00008081 = '00008081';

        $expectedValues = [
            '1-byte' => $_80,
            '2-byte' => $_8081,
            '4-byte' => $_00008081,
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
            '1-byte' => $_80,
            '2-byte' => $_8081,
            '4-byte' => $_00008081,
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
            '1-byte' => $x80,
            '2-byte' => $x8081,
            '4-byte' => $x00008081,
        ];

        return array_map(
            static function ($value, $key) use ($expectedValues) {
                return [$value, $expectedValues[$key]];
            },
            $values,
            array_keys($values)
        );
    }

    private function createType(int $byteCount): BinaryTypeInterface
    {
        return new class($byteCount) implements BinaryTypeInterface {
            public function __construct(
                private int $byteCount
            ) {
            }

            public function getByteCount(): int
            {
                return $this->byteCount;
            }
        };
    }
}