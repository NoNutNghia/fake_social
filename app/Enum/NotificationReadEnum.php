<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class NotificationReadEnum extends Enum implements LocalizedEnum
{
    public const UN_READ = 0;
    public const READ = 1;
}
