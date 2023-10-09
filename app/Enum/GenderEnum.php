<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class GenderEnum extends Enum implements LocalizedEnum
{
    public const MALE = 1;
    public const FEMALE = 2;
    public const OTHER = 3;
}
