<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that fillable fields are configured correctly
     *
     * @test
     */
    public function fillable_fields_are_configured_correctly()
    {
        $expectedFillable = [
            'name',
            'email',
            'password',
            'avatar',
            'role',
        ];

        $user = new User();
        $fillable = $user->getFillable();

        $this->assertEquals($expectedFillable, $fillable);
        $this->assertContains('avatar', $fillable);
        $this->assertContains('role', $fillable);
    }

    /**
     * Test that hidden fields do not appear in JSON
     *
     * @test
     */
    public function hidden_fields_do_not_appear_in_json()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $jsonArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $jsonArray);
        $this->assertArrayNotHasKey('remember_token', $jsonArray);
        $this->assertArrayHasKey('name', $jsonArray);
        $this->assertArrayHasKey('email', $jsonArray);
    }

    /**
     * Test that password is hashed via casting
     *
     * @test
     */
    public function password_is_hashed_via_casting()
    {
        $plainPassword = 'my-secret-password';
        
        $user = User::factory()->create([
            'password' => $plainPassword,
        ]);

        // Password should not be stored as plain text
        $this->assertNotEquals($plainPassword, $user->password);
        
        // Password should be hashed (bcrypt produces 60 character strings)
        $this->assertGreaterThanOrEqual(60, strlen($user->password));
        
        // Verify the password hash is valid
        $this->assertTrue(\Hash::check($plainPassword, $user->password));
    }

    /**
     * Test that avatar field can be mass assigned
     *
     * @test
     */
    public function avatar_field_can_be_mass_assigned()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'avatar' => 'avatars/john.jpg',
        ];

        $user = User::create($userData);

        $this->assertEquals('avatars/john.jpg', $user->avatar);
    }

    /**
     * Test that role field can be mass assigned
     *
     * @test
     */
    public function role_field_can_be_mass_assigned()
    {
        $userData = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $user = User::create($userData);

        $this->assertEquals('admin', $user->role);
    }

    /**
     * Test that hidden array contains password and remember_token
     *
     * @test
     */
    public function hidden_array_contains_required_fields()
    {
        $user = new User();
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
        $this->assertCount(2, $hidden);
    }
}
