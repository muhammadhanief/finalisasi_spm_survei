<?php

namespace Tests\Feature\Livewire;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function test_redirect_to_google()
    {
        // Mock Socialite driver method to return a fake redirect response
        Socialite::shouldReceive('driver->redirect')->andReturn(
            redirect()->away('https://google.com')
        );

        // Call the redirectToGoogle method
        $response = $this->get('/google/redirect');

        // Check if the response is a redirect to Google
        $response->assertRedirect('https://google.com');
    }

    /** @test */
    public function test_handle_google_callback()
    {
        // Simulate user data from Google login
        $userData = [
            'id' => 123456789,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
            // Add other user data as needed
        ];

        // Mock Socialite user method to return fake user data
        Socialite::shouldReceive('driver->user')->andReturn((object) $userData);

        // Mock User model to return null for existing user check
        User::shouldReceive('where->first')->andReturn(null);

        // Call the handleGoogleCallback method
        $response = $this->get('/google/callback');

        // Check if the user is redirected to the dashboard after successful login
        $response->assertRedirect('/dashboard');

        // Check if the user is logged in with correct data
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs(User::where('email', 'john.doe@example.com')->first());
    }
}
