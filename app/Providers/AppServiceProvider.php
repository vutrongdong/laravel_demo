<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\Slide;
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
        //
        $theloai = TheLoai::all();
        $slide = Slide::orderBy("id", "DESC")->take(4)->get();
        View::share('theloai', $theloai);
        View::share('slide', $slide);

        if(Auth::check()){
            View::share('nguoidung', Auth::user());
        }
    }
}
