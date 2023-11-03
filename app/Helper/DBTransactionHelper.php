<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class DBTransactionHelper
{
    static public function handleTransaction($callback)
    {
        return DB::transaction($callback);
    }
}
