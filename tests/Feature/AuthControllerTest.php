<?php

namespace Tests\Feature;

use App\Models\AllowedDomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_view_has_allowed_domains()
    {
        AllowedDomain::create(['domain' => 'example.com']);
        AllowedDomain::create(['domain' => 'test.org']);

        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewHas('allowedDomains', ['example.com', 'test.org']);
    }

    public function test_signup_view_has_allowed_domains()
    {
        AllowedDomain::create(['domain' => 'example.com']);

        $response = $this->get('/signup');

        $response->assertStatus(200);
        $response->assertViewHas('allowedDomains', ['example.com']);
    }

    public function test_send_otp_checks_dynamic_domains()
    {
        AllowedDomain::create(['domain' => 'allowed.com']);

        // Test allowed domain with simple format
        $response = $this->postJson('/auth/send-otp', [
            'email' => 'simple-user@allowed.com'
        ]);
        $response->assertStatus(200);

        // Test blocked domain
        $response = $this->postJson('/auth/send-otp', [
            'email' => 'user@gmail.com'
        ]);
        $response->assertStatus(422);
    }

    public function test_onboarding_view_loads()
    {
        $this->withSession(['user_id' => 1]);
        $response = $this->get('/onboarding');
        $response->assertStatus(200);
        $response->assertViewIs('customer.onboarding');
    }

    public function test_profile_view_loads()
    {
        $this->withSession(['user_id' => 1]);
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response->assertViewIs('customer.profile');
    }

    public function test_discover_page_shows_students()
    {
        \App\Models\Student::create([
            'name' => 'Dynamic Student',
            'email' => 'dynamic@example.com',
            'institute' => 'SIT',
            'course' => 'B.Tech',
            'section' => 'A',
            'campus_location' => 'Main Campus',
            'gym_choice' => 'Hostel Gym',
            'origin' => 'national',
            'current_study_year' => 3,
            'accommodation' => 'Hostel'
        ]);

        $this->withSession([
            'user_id' => 1,
            'onboarding_data' => [
                'institute' => 'SIT',
                'course' => 'B.Tech'
            ]
        ]);

        $response = $this->get('/discover');
        $response->assertStatus(200);
        $response->assertViewHas('students');
        $response->assertSee('Dynamic Student');
    }
}
