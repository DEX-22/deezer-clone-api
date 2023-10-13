<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Traits\DeezerErrorHandlingTrait;

class AlbumTest extends TestCase
{

    // use RefreshDatabase;
    use DeezerErrorHandlingTrait;

    public function test_get_album_by_id_success()
    { 
        [$user,$token ] = $this->getUser();
         
        $response = $this->withTokenHeader($token)->get('/api/album/302127');

        $response->assertStatus(200) ;
    }

    public function test_get_album_by_id_not_valid()
    {
        [$user,$token ] = $this->getUser();
        $response = $this->withTokenHeader($token)->get('/api/album/aaa'); 

        $response->assertStatus(400);
    }
    public function test_get_album_by_id_not_found()
    {
        [$user,$token ] = $this->getUser();
        $response = $this->withTokenHeader($token)->get('/api/album/1212');
         
        $response->assertStatus(404);
    }

    public function test_get_album_by_id_missing_id()
    {
        $response = $this->get('/api/album');

        $response->assertStatus(404);
    }
    
   
    
}
