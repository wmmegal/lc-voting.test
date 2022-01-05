<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_check_if_user_is_an_admin()
    {
        $user = User::factory()->make([
            'name' => 'Andre',
            'email' => 'test@email.com',
        ]);

        $userB = User::factory()->make([
            'name' => 'Andre',
            'email' => 'user@user.com',
        ]);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($userB->isAdmin());
    }
}
