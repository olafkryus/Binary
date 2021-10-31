<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Enum\Endianness;
use Kryus\Binary\Type\FloatingPointTypeInterface;
use Kryus\Binary\Value\FloatingPointValue;
use PHPUnit\Framework\TestCase;

class FloatingPointValueTest extends TestCase
{
    /**
     * @dataProvider endiannessProvider
     */
    public function testDoesReturnCorrectEndianness(int $endianness): void
    {
        $typeStub = $this->createStub(FloatingPointTypeInterface::class);
        $value = new FloatingPointValue($typeStub, ' ', $endianness);

        self::assertSame($endianness, $value->getEndianness());
    }

    public function testCannotInstantiateWithInvalidEndianness(): void
    {
        $typeStub = $this->createStub(FloatingPointTypeInterface::class);
        $this->expectException(\Exception::class);

        new FloatingPointValue($typeStub, ' ', 2);
    }

    /**
     * @dataProvider floatValueTestProvider
     */
    public function testDoesReturnCorrectFloatValue(FloatingPointValue $value, float $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toFloat());
    }

    /**
     * @dataProvider isFiniteTestProvider
     */
    public function testDoesReturnCorrectFiniteStatus(FloatingPointValue $value, bool $expectedStatus): void
    {
        self::assertSame($expectedStatus, $value->isFinite());
    }

    /**
     * @dataProvider isInfiniteTestProvider
     */
    public function testDoesReturnCorrectInfiniteStatus(FloatingPointValue $value, bool $expectedStatus): void
    {
        self::assertSame($expectedStatus, $value->isInfinite());
    }

    /**
     * @dataProvider isNaNTestProvider
     */
    public function testDoesReturnCorrectNaNStatus(FloatingPointValue $value, bool $expectedStatus): void
    {
        self::assertSame($expectedStatus, $value->isNaN());
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
        $x00 = chr(0x00);
        $x3C = chr(0x3C);
        $x3F = chr(0x3F);
        $x40 = chr(0x40);
        $x7F = chr(0x7F);
        $x80 = chr(0x80);
        $x88 = chr(0x88);
        $xBC = chr(0xBC);
        $xBF = chr(0xBF);
        $xF0 = chr(0xF0);
        $xFF = chr(0xFF);
        $x0000 = chr(0x00) . chr(0x00);

        return [
            'single-precision positive little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x3C . $x40 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision positive big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x40 . $x3C, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision negative little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $xBC . $x40 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision negative big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x40 . $xBC, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision positive zero little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision positive zero big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x0000, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision negative zero little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x80 . $x00 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision negative zero big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x00 . $x80, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision positive infinity little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x7F . $x80 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision positive infinity big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x80 . $x7F, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision negative infinity little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $xFF . $x80 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision negative infinity big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x0000 . $x80 . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN),
            'single-precision not a number little endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x7F . $x80 . $x00 . $x3F, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'single-precision not a number big endian' => new FloatingPointValue($this->createType(4, 8, 23, 127), $x3F . $x00 . $x80 . $x7F, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision positive little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x3F . $x88 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision positive big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $x88 . $x3F, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision negative little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $xBF . $x88 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision negative big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $x88 . $xBF, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision positive zero little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision positive zero big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision negative zero little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x80 . $x00 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision negative zero big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $x00 . $x80, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision positive infinity little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x7F . $xF0 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision positive infinity big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $xF0 . $x7F, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision negative infinity little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $xFF . $xF0 . $x0000 . $x0000 . $x0000, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision negative infinity big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x0000 . $x0000 . $x0000 . $xF0 . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN),
            'double-precision not a number little endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x7F . $xF0 . $x0000 . $x0000 . $x00 . $x3F, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            'double-precision not a number big endian' => new FloatingPointValue($this->createType(8, 11, 52, 1023), $x3F . $x00 . $x0000 . $x0000 . $xF0 . $x7F, Endianness::ENDIANNESS_BIG_ENDIAN),
        ];
    }

    public function floatValueTestProvider(): iterable
    {
        $values = $this->getValueTestSet();

        $expectedValues = [
            'single-precision positive little endian' => 0.01171875,
            'single-precision positive big endian' => 0.01171875,
            'single-precision negative little endian' => -0.01171875,
            'single-precision negative big endian' => -0.01171875,
            'single-precision positive zero little endian' => +0.0,
            'single-precision positive zero big endian' => +0.0,
            'single-precision negative zero little endian' => -0.0,
            'single-precision negative zero big endian' => -0.0,
            'single-precision positive infinity little endian' => +INF,
            'single-precision positive infinity big endian' => +INF,
            'single-precision negative infinity little endian' => -INF,
            'single-precision negative infinity big endian' => -INF,
            'double-precision positive little endian' => 0.01171875,
            'double-precision positive big endian' => 0.01171875,
            'double-precision negative little endian' => -0.01171875,
            'double-precision negative big endian' => -0.01171875,
            'double-precision positive zero little endian' => +0.0,
            'double-precision positive zero big endian' => +0.0,
            'double-precision negative zero little endian' => -0.0,
            'double-precision negative zero big endian' => -0.0,
            'double-precision positive infinity little endian' => +INF,
            'double-precision positive infinity big endian' => +INF,
            'double-precision negative infinity little endian' => -INF,
            'double-precision negative infinity big endian' => -INF,
        ];

        foreach ($expectedValues as $key => $expectedValue) {
            yield $key => [$values[$key], $expectedValue];
        }
    }

    public function isFiniteTestProvider(): iterable
    {
        $values = $this->getValueTestSet();

        $expectedValues = [
            'single-precision positive little endian' => true,
            'single-precision positive big endian' => true,
            'single-precision negative little endian' => true,
            'single-precision negative big endian' => true,
            'single-precision positive zero little endian' => true,
            'single-precision positive zero big endian' => true,
            'single-precision negative zero little endian' => true,
            'single-precision negative zero big endian' => true,
            'single-precision positive infinity little endian' => false,
            'single-precision positive infinity big endian' => false,
            'single-precision negative infinity little endian' => false,
            'single-precision negative infinity big endian' => false,
            'single-precision not a number little endian' => false,
            'single-precision not a number big endian' => false,
            'double-precision positive little endian' => true,
            'double-precision positive big endian' => true,
            'double-precision negative little endian' => true,
            'double-precision negative big endian' => true,
            'double-precision positive zero little endian' => true,
            'double-precision positive zero big endian' => true,
            'double-precision negative zero little endian' => true,
            'double-precision negative zero big endian' => true,
            'double-precision positive infinity little endian' => false,
            'double-precision positive infinity big endian' => false,
            'double-precision negative infinity little endian' => false,
            'double-precision negative infinity big endian' => false,
            'double-precision not a number little endian' => false,
            'double-precision not a number big endian' => false,
        ];

        foreach ($expectedValues as $key => $expectedValue) {
            yield $key => [$values[$key], $expectedValue];
        }
    }

    public function isInfiniteTestProvider(): iterable
    {
        $values = $this->getValueTestSet();

        $expectedValues = [
            'single-precision positive little endian' => false,
            'single-precision positive big endian' => false,
            'single-precision negative little endian' => false,
            'single-precision negative big endian' => false,
            'single-precision positive zero little endian' => false,
            'single-precision positive zero big endian' => false,
            'single-precision negative zero little endian' => false,
            'single-precision negative zero big endian' => false,
            'single-precision positive infinity little endian' => true,
            'single-precision positive infinity big endian' => true,
            'single-precision negative infinity little endian' => true,
            'single-precision negative infinity big endian' => true,
            'single-precision not a number little endian' => false,
            'single-precision not a number big endian' => false,
            'double-precision positive little endian' => false,
            'double-precision positive big endian' => false,
            'double-precision negative little endian' => false,
            'double-precision negative big endian' => false,
            'double-precision positive zero little endian' => false,
            'double-precision positive zero big endian' => false,
            'double-precision negative zero little endian' => false,
            'double-precision negative zero big endian' => false,
            'double-precision positive infinity little endian' => true,
            'double-precision positive infinity big endian' => true,
            'double-precision negative infinity little endian' => true,
            'double-precision negative infinity big endian' => true,
            'double-precision not a number little endian' => false,
            'double-precision not a number big endian' => false,
        ];

        foreach ($expectedValues as $key => $expectedValue) {
            yield $key => [$values[$key], $expectedValue];
        }
    }

    public function isNaNTestProvider(): iterable
    {
        $values = $this->getValueTestSet();

        $expectedValues = [
            'single-precision positive little endian' => false,
            'single-precision positive big endian' => false,
            'single-precision negative little endian' => false,
            'single-precision negative big endian' => false,
            'single-precision positive zero little endian' => false,
            'single-precision positive zero big endian' => false,
            'single-precision negative zero little endian' => false,
            'single-precision negative zero big endian' => false,
            'single-precision positive infinity little endian' => false,
            'single-precision positive infinity big endian' => false,
            'single-precision negative infinity little endian' => false,
            'single-precision negative infinity big endian' => false,
            'single-precision not a number little endian' => true,
            'single-precision not a number big endian' => true,
            'double-precision positive little endian' => false,
            'double-precision positive big endian' => false,
            'double-precision negative little endian' => false,
            'double-precision negative big endian' => false,
            'double-precision positive zero little endian' => false,
            'double-precision positive zero big endian' => false,
            'double-precision negative zero little endian' => false,
            'double-precision negative zero big endian' => false,
            'double-precision positive infinity little endian' => false,
            'double-precision positive infinity big endian' => false,
            'double-precision negative infinity little endian' => false,
            'double-precision negative infinity big endian' => false,
            'double-precision not a number little endian' => true,
            'double-precision not a number big endian' => true,
        ];

        foreach ($expectedValues as $key => $expectedValue) {
            yield $key => [$values[$key], $expectedValue];
        }
    }

    private function createType(
        int $byteCount,
        int $exponentBitCount,
        int $significandBitCount,
        int $exponentBias
    ): FloatingPointTypeInterface {
        return new class($byteCount, $exponentBitCount, $significandBitCount, $exponentBias) implements
            FloatingPointTypeInterface {
            public function __construct(
                private int $byteCount,
                private int $exponentBitCount,
                private int $significandBitCount,
                private int $exponentBias
            ) {
            }

            public function getByteCount(): int
            {
                return $this->byteCount;
            }

            public function isSigned(): bool
            {
                return true;
            }

            public function getExponentBitCount(): int
            {
                return $this->exponentBitCount;
            }

            public function getSignificandBitCount(): int
            {
                return $this->significandBitCount;
            }

            public function getExponentBias(): int
            {
                return $this->exponentBias;
            }
        };
    }
}