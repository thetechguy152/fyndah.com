<?php
namespace App\Http\Functions;

use Carbon\Carbon;
use _5balloons\LaravelSmartAds\Models\SmartAdTracking;
use _5balloons\LaravelSmartAds\Models\SmartAd;

use Illuminate\Support\Facades\DB;

  class GlobalFunctions  {


    public static function updateClicks(){
        $slug = '';
        $smartAds =  SmartAd::inRandomOrder()->paginate(1);
        $smartAd->clicks++;
        $smartAd->save();
        if(SmartAdTracking::whereDate('created_at', Carbon::today())->exists()){
            $smartAdTracking = SmartAdTracking::whereDate('created_at', Carbon::today())->first();
            $ad_clicks = json_decode($smartAdTracking->ad_clicks);
            if(isset($ad_clicks->{$smartAd->slug})){
                $ad_clicks->{$smartAd->slug}++;  //Increase clicks if already exists
            }else{
                $ad_clicks->{$smartAd->slug} = 1; //First click of the day
            }
            $totalClicks = $smartAdTracking->totalClicks + 1;
            $smartAdTracking->update([
                'ad_clicks' => json_encode($ad_clicks),
                'totalClicks' => $totalClicks
            ]);
        }else{
            SmartAdTracking::create([
                'totalClicks' => 1,
                'ad_clicks' => json_encode([$smartAd->slug => 1])
            ]);
        }
        
    }
     
    public static function first_global_function() {
        //function logic
        $smartAds =  SmartAd::inRandomOrder()->paginate(1);
      //  DB::table('smart_ads')->increment('views');
        $isAdsClicks = request('is-ads-clicks');

        if($isAdsClicks){
            $smartAds = SmartAd::increment('clicks');
     //  DB::table('smart_ads')->increment('clicks');
        }
       // $totalClicks = SmartAd::sum('clicks');
       // $totalViews = SmartAd::sum('views');
        return    $smartAds;
     
    }
    public static function second_global_function()
    {
          //function logic
         // $smartAds =  SmartAd::inRandomOrder()->paginate(10);
          $smartAds = SmartAd::increment('views');
         // DB::table('smart_ads')->increment('views');
         // DB::table('smart_ads')->increment('clicks');
         // $totalClicks = SmartAd::sum('clicks');
         // $totalViews = SmartAd::sum('views');
          return    $smartAds;
    }

    public static function property_views_global_function()
    {
         //function logic
         $smartAds =  SmartAd::inRandomOrder()->paginate(1);
         //  DB::table('smart_ads')->increment('views');
          // $isAdsClicks = request('is-ads-clicks');
   
           if($isAdsClicks){
          
          DB::table('smart_ads')->increment('clicks');
           }
          // $totalClicks = SmartAd::sum('clicks');
          // $totalViews = SmartAd::sum('views');
           return    $smartAds;
    }

    
}