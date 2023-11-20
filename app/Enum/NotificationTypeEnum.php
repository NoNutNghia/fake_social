<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class NotificationTypeEnum extends Enum implements LocalizedEnum
{
    public const NEW_POST = 'NEW_POST';
    public const COMMENT_POST = 'COMMENT_POST';
    public const FEEL_POST = 'FEEL_POST';
    public const MARK_POST = 'MARK_POST';
}
