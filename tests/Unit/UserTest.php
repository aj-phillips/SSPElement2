<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testThatUserCanBeCreatedAndLoggedIn()
    {
        $user = new User();

        $user->username = "TestUser";
        $user->password = Hash::make("password");
        $user->email = "testuser@test.com";
        $user->dob = Date::createFromDate(2000, 07, 20);

        $response = $this->actingAs($user)->get('/menu');

        $response->assertStatus(200);
    }
}
