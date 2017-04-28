<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){

//        $lastActivities = Activity::orderBy('id','desc')->limit(5)->get();
//        $analytics['browsers'] = Analytics::fetchTopBrowsers(Period::days(30),5);
//        $analytics['countries'] = Analytics::performQuery(Period::days(30),'ga:sessions',['dimensions'=>'ga:country','sort'=>'-ga:sessions','max-results'=>10])->rows;
//        //$analytics['analytics'] = Analytics::performQuery(Period::days(30),'ga:sessions,ga:bounceRate,ga:newUsers,ga:avgSessionDuration,ga:pageviews,ga:hits,ga:exitRate')->totalsForAllResults;
//        //$analytics['countries'] =  $this->shuffle_array($countries);
//        $startDate = Carbon::now()->subDay(30);
//        $endDate = Carbon::now();
//        $analytics['analytics'] = Analytics::performQuery(Period::create($startDate, $endDate),'ga:newUsers,ga:visits,ga:users,ga:bounceRate,ga:pageviews,ga:sessions,ga:entranceBounceRate,ga:hits,ga:exitRate',['dimensions'=>'ga:date'])->rows;
//        $commentsCounts = NewsComment::where('created_at','>',Carbon::now()->subMonth())->count();
//        return view('dashboard.index',$analytics)
//            ->with('commentCounts',$commentsCounts)
//            ->with('lastActivities',$lastActivities);
        return view('dashboard.index');
    }
}
