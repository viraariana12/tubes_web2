<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    /*
    public function testEmailPasswordKosong() {
        $res = $this->postJson('api/user/login',[]);
        $res
            ->assertStatus(422)
            ->assertJson([
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ]);
    }

    public function testEmailTidakTerdaftar() {
        $res = $this->postJson('api/user/login',[
            "email" => "salah@gmail.com",
            "password" => "rahasia"
        ]);
        $res
            ->assertStatus(422)
            ->assertJson([
                "email" => ["E-Mail tidak terdaftar"],
            ]);
    }

    public function testPasswordSalah() {

        $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);
        
        $res = $this->postJson('api/user/login',[
            "email" => "adolf@nazi.ger",
            "password" => "rahasia"
        ]);

        $res
            ->assertStatus(422)
            ->assertJson([
                "password" => ["Password salah"],
            ]);

    }*/

    public function testEmailTerdaftarPasswordBenar() {
        $this->postJson('api/user/register',[
            "nama" => "Adolf Hitler",
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $res = $this->postJson('api/user/login',[
            "email" => "adolf@nazi.ger",
            "password" => "fuhrer"
        ]);

        $res->assertStatus(200);
            
    }

}