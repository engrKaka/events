<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->dashboardSetting();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    protected function dashboardSetting(){
        view()->composer('*',function($view){
            $settings = function($group=null){
                $_settings = Setting::orderBy('group')->orderBy('order');
                if($group!=null){
                    $_settings = $_settings->whereGroup($group)->get();
                }else{
                    $_settings = $_settings->get();
                }
                $data = $_settings->groupBy('group')->map(function($item){
                    return $item->keyBy('type');
                });
                if($group!=null){
                    return $data->only($group)->first();
                }
                return $data;
            };

            $view->with('_setting',$settings);
        });
    }


}
