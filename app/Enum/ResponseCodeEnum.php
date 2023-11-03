<?php

namespace App\Enum;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class ResponseCodeEnum extends Enum implements LocalizedEnum
{
    // OK
    public const CODE_1000 = "1000";

    // Not enough coins
    public const CODE_9991 = "9991";

    // Post is not existed
    public const CODE_9992 = "9992";

    // Code verify is incorrect
    public const CODE_9993 = "9993";

    // No Data or end of list data
    public const CODE_9994 = "9994";

    // User is not validated
    public const CODE_9995 = "9995";

    // User existed
    public const CODE_9996 = "9996";

    // Method is invalid
    public const CODE_9997 = "9997";

    // Token is invalid
    public const CODE_9998 = "9998";

    // Exception error
    public const CODE_9999 = "9999";

    // Can not connect to DB
    public const CODE_1001 = "1001";

    // Parameter is not enough
    public const CODE_1002 = "1002";

    // Parameter type is invalid
    public const CODE_1003 = "1003";

    // Parameter value is invalid
    public const CODE_1004 = "1004";

    // Unknown error
    public const CODE_1005 = "1005";

    // File size is too big
    public const CODE_1006 = "1006";

    // Upload File Failed
    public const CODE_1007 = "1007";

    // Maximum number of images
    public const CODE_1008 = "1008";

    // Not access
    public const CODE_1009 = "1009";

    // Action has been done previous by this user
    public const CODE_1010 = "1010";

    // Could not publish this post
    public const CODE_1011 = "1011";

    // Limited access
    public const CODE_1012 = "1012";
}
