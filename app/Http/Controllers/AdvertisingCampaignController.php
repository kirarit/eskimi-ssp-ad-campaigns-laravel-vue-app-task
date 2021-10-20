<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdvertisingCampaign;

class AdvertisingCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(AdvertisingCampaign::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Validation
         */
        $this->validate($request, [
            'name' => 'required|string|min:3|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'daily_budget' => 'required',
            'total_budget' => 'required'
        ]);
        
        $image_arr = [];
       
        $ad = new AdvertisingCampaign();
        $ad->name = $request->name;
        $ad->from_date = $request->from_date;
        $ad->to_date = $request->to_date;
        $ad->daily_budget = $request->daily_budget;
        $ad->total_budget = $request->total_budget;
        if($request->img){
            foreach($request->img as $file){               
              $image_arr[] = $file['url'];
            }
        }  
        $ad->image_path = json_encode($image_arr);        
        $ad->save();

        return response()->json(['success' => true, 'data' => $ad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvertisingCampaign  $advertisingCampaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvertisingCampaign $advertisingCampaign)
    {
       /**
         * Validation
         */
        $this->validate($request, [
            'name' => 'required|string|min:3|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'daily_budget' => 'required',
            'total_budget' => 'required'
        ]);
        
        $image_arr = [];
        $advertisingCampaign->name = $request->name;
        $advertisingCampaign->from_date = $request->from_date;
        $advertisingCampaign->to_date = $request->to_date;
        $advertisingCampaign->daily_budget = $request->daily_budget;
        $advertisingCampaign->total_budget = $request->total_budget;
        if($request->img){
            foreach($request->img as $file){               
              $image_arr[] = $file['url'];
            }
        } 
        $advertisingCampaign->image_path = json_encode($image_arr); 
        $advertisingCampaign->save();

        return response()->json(['success' => true, 'data' => $advertisingCampaign]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvertisingCampaign  $advertisingCampaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvertisingCampaign $advertisingCampaign)
    {
        $advertisingCampaign->delete();
        return response()->json(null, 204);
    }
}
