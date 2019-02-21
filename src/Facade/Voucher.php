<?php

namespace AmestSantim\Voucherator\Facade;

use Illuminate\Support\Facades\Facade;

class Voucher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Voucher';
    }
}