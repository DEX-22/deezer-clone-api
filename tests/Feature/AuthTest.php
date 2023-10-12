<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_endpoint_is_available()
    {
        $response = $this->post('/api/register',[
            "email"=> "enrique",
            "name"=> "enrique",
            "password"=> "enrique", 
            "country"=> "enrique"
        ]); 

        $response->assertStatus(200);
    }
}
