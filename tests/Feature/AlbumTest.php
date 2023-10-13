<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    // use RefreshDatabase;

    public function test_get_album_by_id_success()
    { 
        [$user,$token ] = $this->getUser();
         
        $response = $this->withTokenHeader($token)->get('/api/album/302127');

        $response->assertStatus(200) ;
    }

    public function test_get_album_by_id_not_found()
    {
        [$user,$token ] = $this->getUser();
         
        
        $response = $this->withTokenHeader($token)->get('/api/album/aaa');

        $response->assertStatus(404);
    }

    public function test_get_album_by_id_missing_id()
    {
        $response = $this->get('/api/album');

        $response->assertStatus(404);
    }
    private function getUser(){
        $user = User::factory()->create()->first(); 

        $token = $user->createToken('Bearer Token')->plainTextToken;
         

        return [ $user, $token];
    }
    private function withTokenHeader($token)
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
   
    
}
