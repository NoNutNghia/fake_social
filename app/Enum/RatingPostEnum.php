<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RatingPostEnum extends Enum implements LocalizedEnum
{
    public const TRUST = 1;
    public const FAKE = 2;
    public const KUDOS = 3;
    public const DISAPPOINTED = 4;
}
