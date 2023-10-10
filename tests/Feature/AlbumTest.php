<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    public function test_endpoint_is_available()
    {
        $id = 30127;

        $response = $this->get("api/album/{$id}");

        $response->assertStatus(200);
    }
}
