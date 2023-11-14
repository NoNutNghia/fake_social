<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class MarkTypeEnum extends Enum implements LocalizedEnum
{
    public const FAKE = 0;
    public const TRUST = 1;
}
