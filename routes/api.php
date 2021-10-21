<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/advertising-campaign', 'AdvertisingCampaignController@index')->name('advertising-campaign.index');
Route::post('/advertising-campaign', 'AdvertisingCampaignController@store')->name('advertising-campaign.store');
Route::put('/advertising-campaign/{advertisingCampaign}', 'AdvertisingCampaignController@update')->name('advertising-campaign.update');
Route::delete('/advertising-campaign/{advertisingCampaign}', 'AdvertisingCampaignController@destroy')->name('advertising-campaign.delete');

