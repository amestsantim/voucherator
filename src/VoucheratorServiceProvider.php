<?php

namespace AmestSantim\Voucherator;

use AmestSantim\Voucherator\Facade\Voucher;
use Illuminate\Support\ServiceProvider;

class ContactFormServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('Voucher', Voucher::class);
    }

    public function register()
    {
    }
}