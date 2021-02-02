<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VersionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test APP Version
     * Simple test to validate everything is working
     *
     * @return void
     */
    public function testAppVersion()
    {
        $response = $this->getJson('/api/version');
        $response
            ->assertStatus(200)
            ->assertJson([
                'version' => true,
            ]);
    }
}
