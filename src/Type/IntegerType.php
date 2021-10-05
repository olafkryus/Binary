<?php

declare(strict_types=1);

namespace Kryus\Binary\Type;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class IntegerType extends NumericType implements IntegerTypeInterface
{
}