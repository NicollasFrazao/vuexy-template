<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /**
     * Test that fillable fields are configured correctly
     * (does not require DB connection)
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

        $user = new User;
        $fillable = $user->getFillable();

        $this->assertEquals($expectedFillable, $fillable);
        $this->assertContains('avatar', $fillable);
        $this->assertContains('role', $fillable);
    }

    /**
     * Test that hidden fields are configured correctly
     * (does not require DB connection)
     *
     * @test
     */
    public function hidden_fields_do_not_appear_in_json()
    {
        $user = new User;
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    /**
     * Test that hidden array contains password and remember_token
     *
     * @test
     */
    public function hidden_array_contains_required_fields()
    {
        $user = new User;
        $hidden = $user->getHidden();

        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
        $this->assertCount(2, $hidden);
    }

    /**
     * Test that password cast is configured
     *
     * @test
     */
    public function password_is_hashed_via_casting()
    {
        $user = new User;
        $casts = $user->getCasts();

        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    /**
     * Test that avatar field is in fillable
     *
     * @test
     */
    public function avatar_field_can_be_mass_assigned()
    {
        $user = new User;
        $this->assertContains('avatar', $user->getFillable());
    }

    /**
     * Test that role field is in fillable
     *
     * @test
     */
    public function role_field_can_be_mass_assigned()
    {
        $user = new User;
        $this->assertContains('role', $user->getFillable());
    }
}
