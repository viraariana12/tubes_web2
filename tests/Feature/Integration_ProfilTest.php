<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\User;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    
    public function testLihatProfilUser() {
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
                    ->get('api/user/profile');

        $res->assertStatus(200)
        ->assertJson([
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger"
        ]);

    }

    public function testUbahProfilUser() {
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
                    ->postJson('api/user/profile',[
                        "nama" => "Josef Stalin",
                        "email" => "stalin@rusky.ru"
                    ]);
                        
        $res->assertStatus(200)
            ->assertJson([
                "nama" => "Josef Stalin",
                "email" => "stalin@rusky.ru"
        ]);
    }
}