<?php

use App\Enum\ResponseCodeEnum;

return [
    ResponseCodeEnum::CODE_1000 => "OK",
    ResponseCodeEnum::CODE_9991 => "Not enough coins",
    ResponseCodeEnum::CODE_9992 => "Post is not existed",
    ResponseCodeEnum::CODE_9993 => "Code verify is incorrect",
    ResponseCodeEnum::CODE_9994 => "No Data or end of list data",
    ResponseCodeEnum::CODE_9995 => "User is not validated",
    ResponseCodeEnum::CODE_9996 => "User existed",
    ResponseCodeEnum::CODE_9997 => "Method is invalid",
    ResponseCodeEnum::CODE_9998 => "Token is invalid",
    ResponseCodeEnum::CODE_9999 => "Exception error",
    ResponseCodeEnum::CODE_1001 => "Can not connect to DB",
    ResponseCodeEnum::CODE_1002 => "Parameter is not enough",
    ResponseCodeEnum::CODE_1003 => "Parameter type is invalid",
    ResponseCodeEnum::CODE_1004 => "Parameter value is invalid",
    ResponseCodeEnum::CODE_1005 => "Unknown error",
    ResponseCodeEnum::CODE_1006 => "File size is too big",
    ResponseCodeEnum::CODE_1007 => "Upload File Failed",
    ResponseCodeEnum::CODE_1008 => "Maximum number of images",
    ResponseCodeEnum::CODE_1009 => "Not access",
    ResponseCodeEnum::CODE_1010 => "Action has been done previous by this user",
];
