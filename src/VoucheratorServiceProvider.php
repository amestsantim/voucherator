<?php

namespace AmestSantim\Voucherator;

use AmestSantim\Voucherator\Facade\Voucher;
use Illuminate\Support\ServiceProvider;

class VoucheratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //$this->app->bind('Voucher', Voucher::class);
    }

    public function register()
    {
        $this->app->singleton(AlphaNumericGenerator::class, function ($app) {
            return new AlphaNumericGenerator();
        });
    }
}