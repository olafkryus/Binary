<?php
declare(strict_types=1);

namespace Kryus\Binary\Tests\Value;

use Kryus\Binary\Value\Int\Byte;
use Kryus\Binary\Value\Int\Dword;
use Kryus\Binary\Value\Int\Word;
use Kryus\Binary\Value\Int\SignedValueInterface;
use Kryus\Binary\Enum\Endianness;
use PHPUnit\Framework\TestCase;

class SignedValueTest extends TestCase
{
    /**
     * @dataProvider validCastToUnsignedProvider
     * @param SignedValueInterface $value
     */
    public function testDoesCastCorrectlyToUnsigned(SignedValueInterface $value): void
    {
        $signedValue = $value->toInt();
        $unsignedValue = $value->toUnsigned()->toInt();

        self::assertSame($signedValue, $unsignedValue);
    }

    /**
     * @dataProvider invalidCastToUnsignedProvider
     * @param SignedValueInterface $value
     */
    public function testCannotCastIncorrectlyToUnsigned(SignedValueInterface $value): void
    {
        $this->expectException(\Exception::class);

        $value->toUnsigned();
    }

    /**
     * @return SignedValueInterface[]
     */
    public function validCastToUnsignedProvider(): array
    {
        $x00 = chr(0x00);
        $x7F = chr(0x7F);
        $xFF = chr(0xFF);

        return [
            '1-byte little endian min' => [new Byte($x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte little endian max' => [new Byte($x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte big endian min' => [new Byte($x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '1-byte big endian max' => [new Byte($x7F, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte little endian min' => [new Word($x00 . $x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte little endian max' => [new Word($xFF . $x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte big endian min' => [new Word($x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte big endian max' => [new Word($x7F . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte little endian min' => [new Dword($x00 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte little endian max' => [new Dword($xFF . $xFF . $xFF . $x7F, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte big endian min' => [new Dword($x00 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte big endian max' => [new Dword($x7F . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
        ];
    }

    /**
     * @return SignedValueInterface[]
     */
    public function invalidCastToUnsignedProvider(): array
    {
        $x00 = chr(0x00);
        $x80 = chr(0x80);
        $xFF = chr(0xFF);

        return [
            '1-byte little endian min' => [new Byte($x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte little endian max' => [new Byte($xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '1-byte big endian min' => [new Byte($x80, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '1-byte big endian max' => [new Byte($xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte little endian min' => [new Word($x00 . $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte little endian max' => [new Word($xFF . $xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '2-byte big endian min' => [new Word($x80 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '2-byte big endian max' => [new Word($xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte little endian min' => [new Dword($x00 . $x00 . $x00 . $x80, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte little endian max' => [new Dword($xFF . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_LITTLE_ENDIAN)],
            '4-byte big endian min' => [new Dword($x80 . $x00 . $x00 . $x00, Endianness::ENDIANNESS_BIG_ENDIAN)],
            '4-byte big endian max' => [new Dword($xFF . $xFF . $xFF . $xFF, Endianness::ENDIANNESS_BIG_ENDIAN)],
        ];
    }
}