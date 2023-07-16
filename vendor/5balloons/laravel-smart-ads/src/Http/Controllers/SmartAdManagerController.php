<?php

namespace _5balloons\LaravelSmartAds\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use _5balloons\LaravelSmartAds\Models\SmartAd;
use _5balloons\LaravelSmartAds\LaravelSmartAdsFacade;

use Illuminate\Support\Facades\DB;
use _5balloons\LaravelSmartAds\Http\Requests\StoreSmartAdRequest;
use PDF;
class SmartAdManagerController extends Controller{

    public function dashboard(){
        return view('smart-ads::smart-ad-manager.dashboard');
    }

    public function index(){
   
       // $smartAds = SmartAd::all()->random(10); // The amount of items you wish to receive
        //$smartAds = SmartAd::orderBy('name')->inRandomOrder()->paginate(5);
      //  $smartAds =  SmartAd::inRandomOrder()->paginate(10);
      $smartAds = SmartAd::orderBy('enabled','ASC')->orderBy('id')->paginate(10);
     
      //  DB::table('smart_ads')->increment('views');
       // DB::table('smart_ads')->increment('clicks');
       // $totalClicks = SmartAd::sum('clicks');
      //  $totalViews = SmartAd::sum('views');
        return view('smart-ads::smart-ad-manager.index', array('smartAds' =>  $smartAds));
    //   $smartAds = SmartAd::orderBy('name','ASC')->orderBy(' enabled')->inRandomOrder()->paginate(20);
        
       // return view('smart-ads::smart-ad-manager.index', array('smartAds'  =>  $smartAds));
    }

    public function createPDF ($id){
        $smartAds = SmartAd::orderBy('enabled','ASC')->orderBy('id')->paginate(10);
        
        $totalClicks = SmartAd::sum('clicks');

        $pdf = PDF::loadView('smart-ads::smart-ad-manager.ads', array('smartAds'  =>  $smartAds))
        ->setPaper('a4', 'portrait');
        return $pdf->download('ads-details.pdf');


        return view('smart-ads::smart-ad-manager.index', compact('smartAds', 'totalClicks'));
    }

    public function allAdsPDF (){
        $smartAds = SmartAd::inRandomOrder();
        $totalClicks = SmartAd::sum('clicks');

        $pdf = PDF::loadView('smart-ads::smart-ad-manager.ads', array('smartAds'  =>  $smartAds))
        ->setPaper('a4', 'portrait');
        return $pdf->download('ads-details.pdf');


        return view('smart-ads::smart-ad-manager.index', compact('smartAds', 'totalClicks'));
    }

    public function show(SmartAd $smartAd){
        return view('smart-ads::smart-ad-manager.show', compact('smartAd'));
    }

    public function create(){
        return view('smart-ads::smart-ad-manager.create');
    }

    public function store(StoreSmartAdRequest $request){

        if(isset($request->image)){
            $imagePath = $request->file('image')->store('image', 'public');
        }

        $smartAd = SmartAd::create([
            'name' => $request->name,
            'slug' => $this->slug($request->name),
            'adType' => $request->adType,
            'body' => isset($request->body) ? $request->body : null,
            'image' => isset($imagePath) ? $imagePath : null,
            'imageUrl' => $request->imageUrl,
            'imageAlt' => $request->imageAlt,
            'enabled' => true,
            'placements' => !empty(json_decode($request->placements)[0]->selector) ? $request->placements : null,
        ]);
        return redirect("/smart-ad-manager/ads/{$smartAd->id}")->with(['message' => 'Ad Created', 'color' => 'green']);
    }

    public function edit(SmartAd $smartAd){
        return view('smart-ads::smart-ad-manager.edit', compact('smartAd'));
    }

    public function update(StoreSmartAdRequest $request, SmartAd $smartAd){

        $smartAd->name = $request->name;
        $smartAd->placements = $request->placements;
        if($request->adType == 'HTML'){
            $smartAd->image = null;
            $smartAd->imageUrl = null;
            $smartAd->imageAlt = null;
            $smartAd->body = $request->body;
        }elseif($request->adType == 'IMAGE'){
            if(isset($request->image)){
                $imagePath = $request->file('image')->store('image', 'public');
                $smartAd->image = $imagePath;
            }

            $smartAd->imageUrl = isset($request->imageUrl) ? $request->imageUrl : null;
            $smartAd->imageAlt = isset($request->imageAlt) ? $request->imageAlt : null;
        }
        $smartAd->adType = $request->adType;

        $smartAd->save();
        return redirect("/smart-ad-manager/ads/{$smartAd->id}")->with(['message' => 'Ad Edited', 'color' => 'green']);
    }

    public function delete(SmartAd $smartAd){
        $smartAd->delete();
        return redirect('/smart-ad-manager/ads')->with(['message' => 'Ad Deleted', 'color' => 'green']);
    }

    public function autoAds(){
        $ads = SmartAd::whereNotNull('placements')->get();
        return $ads;
    }

    /**
     * Adds click count to the add
     */
    public function updateClicks(Request $request){
        $slug = $request->get('slug');
        LaravelSmartAdsFacade::updateClicks($slug);
    }

    /**
     * Adds views count to the add
     */


    public function updateViews(Request $request){
        $slug = $request->get('slug');
        LaravelSmartAdsFacade::updateViews($slug);
    }

    //*Enable the Ad */
    public function enable(SmartAd $smartAd){
        $smartAd->enabled = true;
        $smartAd->save();
        return redirect('/smart-ad-manager/ads')->with(['message' => 'Ad Enabled', 'color' => 'green']);
    }

     //*Disable the Ad */
     public function disable(SmartAd $smartAd){
        $smartAd->enabled = false;
        $smartAd->save();
        return redirect('/smart-ad-manager/ads')->with(['message' => 'Ad Disabled', 'color' => 'green']);
    }

    protected function slug($data)
    {
        $ex = explode(' ', $data);
        return implode('-', $ex);
    }
}

