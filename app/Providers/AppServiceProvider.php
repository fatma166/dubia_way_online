<?php


namespace App\Providers;
//use App\Models\Setting;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
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
         $userTimezone1=BusinessSetting::where('key','timezone')->first();//'Asia/Riyadh';
        $userTimezone=$userTimezone1->value??"Africa/Cairo";
// Set the application's timezone dynamically
        Config::set('app.timezone',$userTimezone);
        date_default_timezone_set($userTimezone);
        //
        Paginator::useBootstrap();

        view()->composer('*', function($view)
        {
            $session = session()->get('color_scheme_mode');
            if (!$session)
                session()->put('color_scheme_mode', "light");

            $view->with(['color_scheme_mode' => session()->get("color_scheme_mode", "light")]);
        });

       // view()->composer(['layouts.master', 'admin.auth.login'], function($view){
          //  $view->with('settings', Setting::first());
      //  });
        // Share categories only in web views
        view()->composer(['layouts.website.includes.nav'], function ($view) {
            $id=config('app.default_vendor');
            $categories = Category::where(['position'=>0,'status'=>1])->
            orderBy('priority','desc')->where('restaurant_id',$id)->get();
            $view->with('categories', $categories); // Share categories with specified views
        });
        view()->composer(['layouts.website.includes.footer'], function ($view) {
            $id=config('app.default_vendor');
            $data['business_setting']= BusinessSetting::get()->toArray();
            $data['place']= Restaurant::where('id',config('app.default_vendor'))->first();
            $view->with('data', $data); // Share categories with specified views
        });
    }
}
