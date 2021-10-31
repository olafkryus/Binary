<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Type\IntegerTypeInterface;
use Kryus\Binary\Value\IntegerValue;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class IntegerValueTest extends TestCase
{
    /**
     * @dataProvider endiannessProvider
     */
    public function testDoesReturnCorrectEndianness(int $endianness): void
    {
        $typeStub = $this->createStub(IntegerTypeInterface::class);
        $value = new IntegerValue($typeStub, ' ', $endianness);

        self::assertSame($endianness, $value->getEndianness());
    }

    public function testCannotInstantiateWithInvalidEndianness(): void
    {
        $typeStub = $this->createStub(IntegerTypeInterface::class);
        $this->expectException(\Exception::class);

        new IntegerValue($typeStub, ' ', 2);
    }

    /**
     * @dataProvider intValueTestProvider
     */
    public function testDoesReturnCorrectIntValue(IntegerValue $value, int $expectedValue): void
    {
        self::assertSame($expectedValue, $value->toInt());
    }

    public function endiannessProvider(): iterable
    {
        yield 'little endian' => [Endianness::ENDIANNESS_LITTLE_ENDIAN];
        yield 'big endian' => [Endianness::ENDIANNESS_BIG_ENDIAN];
    }

    private function getValueTestSet(): array
    {
        $x80 = chr(0x80);
        $x8081 = chr(0x80) . chr(0x81);
        $x00008081 = chr(0x00) . chr(0x00) . chr(0x80) . chr(0x81);

        return [
            '1-byte little endian signed' => new IntegerValue($this->createType(1, true), $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '1-byte big endian signed' => new IntegerValue($this->createType(1, true), $x80, Endianness::ENDIANNESS_BIG_ENDIAN),
            '1-byte little endian unsigned' => new IntegerValue($this->createType(1, false), $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '1-byte big endian unsigned' => new IntegerValue($this->createType(1, false), $x80, Endianness::ENDIANNESS_BIG_ENDIAN),
            '2-byte little endian signed' => new IntegerValue($this->createType(2, true), $x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '2-byte big endian signed' => new IntegerValue($this->createType(2, true), $x8081, Endianness::ENDIANNESS_BIG_ENDIAN),
            '2-byte little endian unsigned' => new IntegerValue($this->createType(2, false), $x8081, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '2-byte big endian unsigned' => new IntegerValue($this->createType(2, false), $x8081, Endianness::ENDIANNESS_BIG_ENDIAN),
            '4-byte little endian signed' => new IntegerValue($this->createType(4, true), $x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '4-byte big endian signed' => new IntegerValue($this->createType(4, true), $x00008081, Endianness::ENDIANNESS_BIG_ENDIAN),
            '4-byte little endian unsigned' => new IntegerValue($this->createType(4, false), $x00008081, Endianness::ENDIANNESS_LITTLE_ENDIAN),
            '4-byte big endian unsigned' => new IntegerValue($this->createType(4, false), $x00008081, Endianness::ENDIANNESS_BIG_ENDIAN),
        ];
    }

    public function intValueTestProvider(): iterable
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

        foreach ($expectedValues as $key => $expectedValue) {
            yield $key => [$values[$key], $expectedValue];
        }
    }

    private function createType(int $byteCount, bool $isSigned): IntegerTypeInterface
    {
        return new class($byteCount, $isSigned) implements IntegerTypeInterface {
            public function __construct(
                private int $byteCount,
                private bool $isSigned
            ) {
            }

            public function getByteCount(): int
            {
                return $this->byteCount;
            }

            public function isSigned(): bool
            {
                return $this->isSigned;
            }
        };
    }
}