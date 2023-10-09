<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class PostStatusEnum extends Enum implements LocalizedEnum
{
    public const PUBLIC_POST = 1;
    public const FRIENDS = 2;
    public const PRIVATE_POST = 3;
    public const DELETE_POST = 4;
}
