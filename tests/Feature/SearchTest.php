<?php

namespace Tests\Feature;

use App\Models\User; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Traits\Helpers\TestHelperTrait;

class SearchTest extends TestCase
{ 
    use TestHelperTrait, RefreshDatabase;

    public function test_successful_search()
    {   
        [$user,$token] = $this->getUser();

        $response = $this->withTokenHeader($token)->get('/api/search?query=example');
        $response->assertStatus(200);
    }
 
    public function test_missing_query_parameter()
    {
        [$user,$token] = $this->getUser();

        $response = $this->withTokenHeader($token)->get('/api/search');
        $response->assertStatus(400)
            ->assertJson(['error' => 'Query is required']);
    } 
}
