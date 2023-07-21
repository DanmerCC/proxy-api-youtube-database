<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YoutubeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/api/url', ['url' => 'https://www.youtube.com/watch?v=cDiWGuqzzio']);
        dd($response->getContent());
        $response->assertStatus(200);
    }
}
