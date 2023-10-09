<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RoleEnum extends Enum implements LocalizedEnum
{
    public const ADMIN = 1;
    public const  USER = 2;
}
