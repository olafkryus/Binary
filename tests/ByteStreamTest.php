<?php

declare(strict_types=1);

namespace Kryus\Binary\Tests;

use Kryus\Binary\ByteStream;
use Kryus\Binary\Type;
use PHPUnit\Framework\TestCase;

class ByteStreamTest extends TestCase
{
    public function testClassWithConstructor(): void
    {
        $handle = tmpfile();
        fwrite($handle, chr(20) . chr(30));
        rewind($handle);

        $byteStream = new ByteStream($handle);

        $a = new class(20, 30) {
            public int $a;
            private int $b;
            public int $c;

            public function __construct(
                #[Type\Int\Byte] int $b,
                #[Type\Int\Byte] int $c
            ) {
                $this->b = $b;
                $this->c = $c;
            }

            public function getB(): int
            {
                return $this->b;
            }

            public function getC(): int
            {
                return $this->c;
            }
        };
        $b = $byteStream->readObject(get_class($a));

        $this->assertEquals($a->getB(), $b->getB());
        $this->assertEquals($a->getC(), $b->getC());
    }

    public function testClassWithPublicProperties(): void
    {
        $handle = tmpfile();
        fwrite($handle, chr(20) . chr(30));
        rewind($handle);

        $byteStream = new ByteStream($handle);

        $a = new class {
            #[Type\Int\Byte]
            public int $a;

            private int $b;

            #[Type\Int\Byte]
            public int $c;

            public function getA(): int
            {
                return $this->a;
            }

            public function getC(): int
            {
                return $this->c;
            }
        };
        $a->a = 20;
        $a->c = 30;
        $b = $byteStream->readObject(get_class($a));

        $this->assertEquals($a->getA(), $b->getA());
        $this->assertEquals($a->getC(), $b->getC());
    }
}
