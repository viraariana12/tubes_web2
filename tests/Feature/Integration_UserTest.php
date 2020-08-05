<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testMembuatUser()
    {
        User::create([
            "nama" => "UserBaru",
            "email" => "userbaru@gmail.com",
            "password" => "rahasia"
        ]);

        $this->assertDatabaseHas('users', [
            "nama" => "UserBaru",
            "email" => "userbaru@gmail.com",
            "password" => "rahasia"
        ]);
    }

    public function testMengubahUser()
    {
        $user = User::create([
            "nama" => "UserBaru",
            "email" => "userbaru@gmail.com",
            "password" => "rahasia"
        ]);
        
        $user->update([
            "nama" => "UserBerubah",
            "email" => "emailberubah@gmail.com",
            "password" => "password"
        ]);

        $this->assertDatabaseHas('users', [
            "nama" => "UserBerubah",
            "email" => "emailberubah@gmail.com",
            "password" => "password"
        ]);
    }

    public function testHapusUser() {
        $user = User::create([
            "nama" => "UserBaru",
            "email" => "userbaru@gmail.com",
            "password" => "rahasia"
        ]);

        $user->delete();

        $this->assertDeleted('users',[
            "nama" => "UserBaru",
            "email" => "userbaru@gmail.com",
            "password" => "rahasia"
        ]);
    }
}