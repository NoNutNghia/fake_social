<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RequestStatusEnum extends Enum implements LocalizedEnum
{
    public const USER_APPROVE = 1;
    public const USER_DENY = 2;
    public const USER_PENDING = 3;
}
