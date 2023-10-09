<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusUserEnum extends Enum implements LocalizedEnum
{
    public const ACTIVE = 1;
    public const INACTIVE = 2;
    public const DISABLE = 3;
}
