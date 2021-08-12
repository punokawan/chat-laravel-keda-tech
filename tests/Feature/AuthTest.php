<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * test if email is missing
     *
     * @return void
     */
    public function testLoginShouldThrowAnErrorIfEmailIsMissing()
    {
        $response = $this->post('/api/auth/login');

        $response->assertStatus(self::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['errors'=>['email']]);
    }
    
    /**
     * test if password is missing
     *
     * @return void
     */
    public function testLoginShouldThrowAnErrorIfPasswordIsMissing()
    {
        $response = $this->post('/api/auth/login');

        $response->assertStatus(self::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['errors'=>['password']]);
    }

    /**
     * test if the login return successful results
     *
     * @return void
     */
    public function testLoginShouldReturnSuccessIfAllGoesWell()
    {
        $post = [
            'email' => 'customer@gmail.com',
            'password' => 'dummydummy'
        ];

        $this->post('/api/auth/login', $post)
            ->assertStatus(self::HTTP_OK)
            ->assertJsonStructure(['access_token', 'token' => ['scopes'] , 'token_type'])
            ;
    }
}
