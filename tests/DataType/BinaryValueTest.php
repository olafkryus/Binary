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

    public function signednessProvider(): array
    {
        return [
            'signed' => [true],
            'unsigned' => [false],
        ];
    }
}