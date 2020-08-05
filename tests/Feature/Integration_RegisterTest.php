<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    /*
    public function testNamaEmailPasswordKosong() {
        $res = $this->postJson('api/user/register',[]);
        $res
            ->assertStatus(422)
            ->assertJson([
                "nama" => ["The nama field is required."],
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ]);
    }*/

    public function testNamaEmailPasswordTerisi() {
        $res = $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $res->assertStatus(201);
        $this->assertDatabaseHas('users', [
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
        ]);
    }

    /*
    public function testEmailSudahTerdaftarSebelumnya() {
        
        $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $res = $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $res
            ->assertStatus(422)
            ->assertJson([
                "email" => ["The email has already been taken."],
            ]);

    }*/
}