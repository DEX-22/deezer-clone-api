<?php

namespace Tests\Feature;

use App\Traits\Helpers\TestHelperTrait  ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase; 

class ArtistTest extends TestCase
{
    use TestHelperTrait, RefreshDatabase;

    public function test_get_artist_by_id_success()
    {
        $artistId =  99998;
        [$user,$token ] = $this->getUser();
        $response = $this->withTokenHeader($token)->get('/api/artist/' . $artistId);

         $response->assertStatus(200); 
    }

    public function test_get_artist_by_id_failure()
    {
         $artistId = 9999999;
        [$user,$token ] = $this->getUser();
         $response = $this->withTokenHeader($token)->get('/api/artist/' . $artistId);

         $response->assertStatus(404);
    }

    public function test_get_artist_by_id_missing_id()
    {
        // Make a GET request to the getArtistById endpoint without providing an artist ID
        $response = $this->get('/api/artist/');

        // Assert that the response status code is 400 (Bad Request)
        $response->assertStatus(404);
    }
}
