<?php

namespace _5balloons\LaravelSmartAds\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB; 
use _5balloons\LaravelSmartAds\Models\SmartAd;

class AdReportComponent extends Component
{
    // Report Start and End Date
    public $reportStartDate;
    public $reportEndDate;

    //Properties to show dashboard summary data
    public $clicksToday = 0;
    public $clicksYesterday = 0;
    public $clicks7Days = 0;
    public $clicksThisMonth = 0;

    //Properties to create chart data
    public $clicksPerDate = [];
    public $clicksPerAd = [];





 
    //Properties to show dashboard summary data
    public $viewssToday = 0;
    public $viewsYesterday = 0;
    public $views7Days = 0;
    public $viewsThisMonth = 0;

    //Properties to create chart data
    public $viewsPerDate = [];
    public $viewsPerAd = [];



    public function render()
    {
        //clicks
        $this->clicksToday = SmartAd::whereDate('created_at', Carbon::today())->sum('clicks');
        $this->clicksYesterday = SmartAd::whereDate('created_at', Carbon::yesterday())->sum('clicks');
        $this->clicks7Days = SmartAd::whereBetween(DB::raw('DATE(created_at)'), [Carbon::today()->subDays(7), Carbon::today()])->sum('clicks');
        $this->clicksThisMonth = SmartAd::whereMonth('created_at', Carbon::now()->month)->sum('clicks');



        //views
        $this->viewsToday = SmartAd::whereDate('created_at', Carbon::today())->sum('views');
        $this->viewsYesterday = SmartAd::whereDate('created_at', Carbon::yesterday())->sum('views');
        $this->views7Days = SmartAd::whereBetween(DB::raw('DATE(created_at)'), [Carbon::today()->subDays(7), Carbon::today()])->sum('views');
        $this->viewsThisMonth = SmartAd::whereMonth('created_at', Carbon::now()->month)->sum('views');
    

        return view('smart-ads::livewire.ad-report-component');
    }

    public function calculateClicksReport(){
        $date_from = Carbon::parse($this->reportStartDate)->startOfDay();
        $date_to = Carbon::parse($this->reportEndDate)->endOfDay();
        $SmartAd = SmartAd::
                        where('created_at', '>=', $date_from)
                        ->where('created_at', '<', $date_to)
                        ->get();

        //Calculate clicks per date
        $dateClicksCollection = $SmartAd->mapWithKeys(function ($item, $key) {
            return [$item->created_at->format('Y-m-d') => $item->clicks];
        });
        $period = CarbonPeriod::create($this->reportStartDate, $this->reportEndDate);
        $result = collect();
        foreach($period as $p){
            if($dateClicksCollection->has($p->format('Y-m-d'))){
                $result[$p->format('Y-m-d')] = $dateClicksCollection->get($p->format('Y-m-d'));
            }else{
                $result[$p->format('Y-m-d')] = 0;
            }
        }
        $this->clicksPerDate = $result->toArray();

        //Calculate clicks per ad in the given period
        $adClicksCollection = $SmartAd->map(function($item, $key){
            return json_decode($item['ad_clicks'], true);
        });


        $ads = SmartAd::all();
        foreach($ads as $ad){
            array_push($this->clicksPerAd, ['name' => $ad->name,  'clicks' => $adClicksCollection->sum($ad->slug)]);
        }

        $this->clicksPerAd = collect($this->clicksPerAd)->sortByDesc('clicks')->values()->all();

        $this->emit('renderChart');

    }



    public function calculateViewsReport(){
        $date_from = Carbon::parse($this->reportStartDate)->startOfDay();
        $date_to = Carbon::parse($this->reportEndDate)->endOfDay();
        $SmartAd = SmartAd::
                        where('created_at', '>=', $date_from)
                        ->where('created_at', '<', $date_to)
                        ->get();

        //Calculate clicks per date
        $dateViewsCollection = $SmartAd->mapWithKeys(function ($item, $key) {
            return [$item->created_at->format('Y-m-d') => $item->views];
        });
        $period = CarbonPeriod::create($this->reportStartDate, $this->reportEndDate);
        $result = collect();
        foreach($period as $p){
            if($dateViewsCollection->has($p->format('Y-m-d'))){
                $result[$p->format('Y-m-d')] = $dateViewsCollection->get($p->format('Y-m-d'));
            }else{
                $result[$p->format('Y-m-d')] = 0;
            }
        }
        $this->viewsPerDate = $result->toArray();

        //Calculate views per ad in the given period
        $adViewsCollection = $SmartAd->map(function($item, $key){
            return json_decode($item['ad_views'], true);
        });


        $ads = SmartAd::all();
        foreach($ads as $ad){
            array_push($this->viewsPerAd, ['name' => $ad->name,  'views' => $adViewsCollection->sum($ad->slug)]);
        }

        $this->viewsPerAd = collect($this->viewsPerAd)->sortByDesc('views')->values()->all();

        $this->emit('renderChart');

    }
}
