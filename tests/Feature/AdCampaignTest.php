<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AdvertisingCampaign;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdCampaignTest extends TestCase
{
    /** test index*/
    public function test_campaign_ad_index()
    {
        //Given we have an ad in the database
        $ad = AdvertisingCampaign::factory()->create();

        //When user visit the home page
        $response = $this->get('api/advertising-campaign');

        //He should be able to read the task
        $response->assertSee($ad->name);
    }

    /** test store*/
    public function test_campaign_ad_create()
    {
        $response = $this->withHeaders([])->json('post', route('advertising-campaign.store'), [
            'name' => 'Testing Name',
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->addYear()->format('Y-m-d'),
            'daily_budget' => rand(30, 80),
            'total_budget' => rand(3000, 8000),
            'image_path' => md5(10)
        ]);
        $response->assertStatus(200);
    }

    /** test update*/
    public function test_campaign_ad_update()
    {
        $ad = AdvertisingCampaign::create([
            'name' => 'Testing Name',
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->addYear()->format('Y-m-d'),
            'daily_budget' => rand(30, 80),
            'total_budget' => rand(3000, 8000),
            'image_path' => md5(10)
        ]);
        $response = $this->withHeaders([])->json('put', route('advertising-campaign.update', $ad), [
            'name' => 'Updated Testing Name',
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->addYear()->format('Y-m-d'),
            'daily_budget' => rand(30, 80),
            'total_budget' => rand(3000, 8000),
            'image_path' => md5(10)
        ]);
        $response->assertStatus(200);
    }

    /** test delete*/
    public function test_campaign_ad_delete()
    {
        $ad = AdvertisingCampaign::create([
            'name' => 'Testing Name',
            'from_date' => now()->format('Y-m-d'),
            'to_date' => now()->addYear()->format('Y-m-d'),
            'daily_budget' => rand(30, 80),
            'total_budget' => rand(3000, 8000),
            'image_path' => md5(10)
        ]);
        $response = $this->withHeaders([])->json('delete', route('advertising-campaign.delete', $ad));
        $response->assertStatus(204);
    }
}
