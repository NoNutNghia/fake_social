<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RatingPostEnum extends Enum implements LocalizedEnum
{
    public const KUDOS = 1;
    public const DISAPPOINTED = 0;
}
