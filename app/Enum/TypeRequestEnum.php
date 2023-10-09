<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class TypeRequestEnum extends Enum implements LocalizedEnum
{
    public const USER_RECEIVE = 1;
    public const USER_SEND = 2;
}
