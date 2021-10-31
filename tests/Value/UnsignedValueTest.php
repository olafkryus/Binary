<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Value\Int\UnsignedByte;
use Kryus\Binary\Value\Int\UnsignedDword;
use Kryus\Binary\Value\Int\UnsignedValueInterface;
use Kryus\Binary\Value\Int\UnsignedWord;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class UnsignedValueTest extends TestCase
{
    /**
     * @dataProvider validCastToSignedProvider
     * @param UnsignedValueInterface $value
     */
    public function testDoesCastCorrectlyToSigned(UnsignedValueInterface $value): void
    {
        $unsignedValue = $value->toInt();
        $signedValue = $value->toSigned()->toInt();

        self::assertSame($unsignedValue, $signedValue);
    }

    /**
     * @dataProvider invalidCastToSignedProvider
     * @param UnsignedValueInterface $value
     */
    public function testCannotCastIncorrectlyToSigned(UnsignedValueInterface $value): void
    {
        $this->expectException(\Exception::class);

        $value->toSigned();
    }

    /**
     * @return UnsignedValueInterface[]
     */
    public function validCastToSignedProvider(): array
    {
        $x00 = chr(0x00);
        $x7F = chr(0x7F);
        $xFF = chr(0xFF);

        return [
            '1-byte little endian min' => [new UnsignedByte($x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte little endian max' => [new UnsignedByte($x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte big endian min' => [new UnsignedByte($x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '1-byte big endian max' => [new UnsignedByte($x7F, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte little endian min' => [new UnsignedWord($x00 . $x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte little endian max' => [new UnsignedWord($xFF . $x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte big endian min' => [new UnsignedWord($x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte big endian max' => [new UnsignedWord($x7F . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte little endian min' => [new UnsignedDword($x00 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte little endian max' => [new UnsignedDword($xFF . $xFF . $xFF . $x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte big endian min' => [new UnsignedDword($x00 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte big endian max' => [new UnsignedDword($x7F . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
        ];
    }

    /**
     * @return UnsignedValueInterface[]
     */
    public function invalidCastToSignedProvider(): array
    {
        $x00 = chr(0x00);
        $x80 = chr(0x80);
        $xFF = chr(0xFF);

        return [
            '1-byte little endian min' => [new UnsignedByte($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte little endian max' => [new UnsignedByte($xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte big endian min' => [new UnsignedByte($x80, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '1-byte big endian max' => [new UnsignedByte($xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte little endian min' => [new UnsignedWord($x00 . $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte little endian max' => [new UnsignedWord($xFF . $xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte big endian min' => [new UnsignedWord($x80 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte big endian max' => [new UnsignedWord($xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte little endian min' => [new UnsignedDword($x00 . $x00 . $x00 . $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte little endian max' => [new UnsignedDword($xFF . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte big endian min' => [new UnsignedDword($x80 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte big endian max' => [new UnsignedDword($xFF . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
        ];
    }
}