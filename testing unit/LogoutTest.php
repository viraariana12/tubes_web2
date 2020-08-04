<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    
    public function testLogoutSudahLogin() {
        $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $this->postJson('api/user/login',[
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $user = User::where('email','adolf@nazi.ger')->first();

        $res = $this->actingAs($user)
                    ->postJson('api/user/logout');

        $res->assertStatus(204);

    }

    public function testLogoutBelumLogin() {

        $res = $this->postJson('api/user/logout');
                        
        $res->assertStatus(500);
    }
}