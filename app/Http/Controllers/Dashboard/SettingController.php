<?php

namespace App\Http\Controllers\Dashboard;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->segment(3) =='home_page'){
            return view('dashboard.settings.home');
        }elseif (request()->segment(3)=='general'){
            return view('dashboard.settings.home');
        }elseif (request()->segment(3)=='social'){
            return view('dashboard.settings.social');
        }else{
            return view('dashboard.settings.info');
        }

    }



    public function update(Request $request,$slug)
    {
//        return $key;
        foreach ($request->all() as $key=>$value){
            if($slug=='home_page' && $key=='slider_background' && $request->hasFile('slider_background')){

                $image = $request->file('slider_background');
                $extension = $image->getClientOriginalExtension();
                $filename = md5(microtime()).'.'.$extension;
                $path = public_path('images');
                $image->move($path, $filename);
                $setting = Setting::whereGroup($slug)->whereType('slider_background')->first();
                if(!empty(($setting->value)) && file_exists(public_path('images/'.$setting->value))) {
                    unlink(public_path('images/'.$setting->value));
                }
                $setting->value = $filename;
                $setting->save();
            }else{
                if ($slug=='general' && $key=='language')
                {
                    App::setLocale($value);
                }
                Setting::whereGroup($slug)->whereType($key)->update(['value'=>$value]);
            }
        }

        session()->flash("toastr", ["message" => trans('messages.settings',array(2)), "title" => trans('setting.updated'), "type" => "success"]);
        return back();

    }


    protected function format($settings,$type=null){
        if($settings->count()>0) {
            $data = $settings->groupBy('group')->map(function($item){
                return $item->keyBy('type');
            });
            if($type!=null){
                return $data->only($type)->first();
            }
            return $data;
        }
    }

}
