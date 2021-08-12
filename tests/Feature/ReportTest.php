<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * test if token is missing
     *
     * @return void
     */
    public function testLoginShouldThrowAnErrorIftokenIsMissing()
    {
        $response = $this->post('/api/report');

        $response->assertStatus(self::HTTP_UNAUTHORIZED);
    }
}
