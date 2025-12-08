<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Autentifikācijas mēģinājums bez lietotāja vārda vai paroles
     */
    public function test_login_fails_without_credentials()
    {
        // Mēģinām pieteikties bez datiem
        $response = $this->post('/login', [
            'email' => '',
            'password' => ''
        ]);

        // Pārbaudām, ka tika atgriezti validācijas kļūdu ziņojumi
        $response->assertSessionHasErrors(['email', 'password']);
        
        // Pārbaudām, ka lietotājs netika autentificēts
        $this->assertGuest();
    }

    /**
     * Test 2: Autentifikācijas mēģinājums ar korektu e-pastu un nepareizu paroli
     */
    public function test_login_fails_with_incorrect_password()
    {
        // Izveidojam lietotāju
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correct-password')
        ]);

        // Mēģinām pieteikties ar nepareizu paroli
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password'
        ]);

        // Pārbaudām, ka tika atgriezts kļūdas ziņojums
        $response->assertSessionHasErrors();
        
        // Pārbaudām, ka lietotājs netika autentificēts
        $this->assertGuest();
    }

    /**
     * Test 3: Veiksmīga autentifikācija ar pareiziem datiem
     */
    public function test_login_succeeds_with_correct_credentials()
    {
        // Izveidojam lietotāju
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correct-password')
        ]);

        // Mēģinām pieteikties ar pareiziem datiem
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'correct-password'
        ]);

        // Pārbaudām, ka lietotājs tika autentificēts
        $this->assertAuthenticated();
        
        // Pārbaudām, ka tika veikta pāradresācija (uz home route)
        $response->assertRedirect('/'); // vai assertStatus(302)
    }

    /**
     * Test 4: Reģistrācija ar korektu informāciju
     */
    public function test_registration_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'Jānis Bērziņš',
            'email' => 'janis@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        // Pārbaudām, ka lietotājs tika izveidots
        $this->assertDatabaseHas('users', [
            'email' => 'janis@example.com'
        ]);

        // Pārbaudām, ka lietotājs tika autentificēts
        $this->assertAuthenticated();
    }

    /**
     * Test 5: Reģistrācija ar jau eksistējošu e-pastu
     */
    public function test_registration_fails_with_existing_email()
    {
        // Izveidojam lietotāju
        User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        // Mēģinām reģistrēties ar to pašu e-pastu
        $response = $this->post('/register', [
            'name' => 'Jauns Lietotājs',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        // Pārbaudām, ka tika atgriezts kļūdas ziņojums
        $response->assertSessionHasErrors('email');
    }
}