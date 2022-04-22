<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::macro('toFormatDate',function (){
			return $this->format('Y-m-d');
		});

		Carbon::macro('toFormatTime',function (){
			return $this->format('h:i A');
		});
    }
}
