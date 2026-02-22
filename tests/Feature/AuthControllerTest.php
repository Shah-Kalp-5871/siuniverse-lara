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

    public function test_login_requires_existing_student_record()
    {
        AllowedDomain::create(['domain' => 'student.edu']);

        // no student created yet, should fail
        $response = $this->post('/login', [
            'email' => 'noone@student.edu',
            'password' => 'whatever',
        ]);
        $response->assertSessionHas('error', 'No account found with that email. Please sign up first.');
        $response->assertRedirect();
    }

    public function test_login_fails_with_wrong_password()
    {
        AllowedDomain::create(['domain' => 'student.edu']);
        \App\Models\Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.edu',
            'password' => \Illuminate\Support\Facades\Hash::make('correct'),
            'institute' => 'Test Institute',
            'course' => 'Test Course',
            'section' => 'A',
            'campus_location' => 'Main Campus',
            'current_study_year' => 1,
            'origin' => 'national',
            'accommodation' => 'Hostel'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@student.edu',
            'password' => 'wrong',
        ]);
        $response->assertSessionHas('error', 'Invalid credentials. Please check your password.');
    }

    public function test_login_succeeds_with_student_in_database()
    {
        AllowedDomain::create(['domain' => 'student.edu']);
        \App\Models\Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.edu',
            'password' => \Illuminate\Support\Facades\Hash::make('secret123'),
            'institute' => 'Test Institute',
            'course' => 'Test Course',
            'section' => 'A',
            'campus_location' => 'Main Campus',
            'current_study_year' => 1,
            'origin' => 'national',
            'accommodation' => 'Hostel'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@student.edu',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(route('home')); // intended
        $this->assertEquals(session('user_name'), 'Test Student');
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

    public function test_onboarding_saves_hashed_password()
    {
        // simulate user who completed OTP step
        session(['email' => 'hash@test.edu']);

        $response = $this->post('/onboarding', [
            'name' => 'Hash Tester',
            'accommodation' => 'Hostel',
            'campus' => 'Hill Base',
            'institute' => 'SIT',
            'course' => 'CS',
            'section' => 'Section A',
            'year' => 2,
            'country' => 'India',
            'password' => 'supersecret',
            'password_confirmation' => 'supersecret',
        ]);

        $response->assertRedirect(route('dashboard'));
        $student = \App\Models\Student::where('email', 'hash@test.edu')->first();
        $this->assertNotNull($student);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('supersecret', $student->password));
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
