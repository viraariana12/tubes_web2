<?php

namespace Tests\Feature;

use Tests\Testcase;
use App\Media;
use File;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\http\UploadedFile;

class AploudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testAddImage()
    {
        //$response = $this->get('/');
        $path = storage_path('testing\Gambar.jpg');
        $originName = "Gambar.jpg";
        $name = 'img/jpg';
        $file = new UploadedFile($path, $originName, 0, null, true);
        $nama_file = time()."_".$file->getClientOriginalName();

        $data = new Media();

        $data->nama= "Vira";
        $data->jenis="pup";
        $data->url="Gambar.jpg";
    
        $data->save();

        $toCopy = public_path('/uploads'.$nama_file);
        File::copy($path, $toCopy);

        $this->assertDatabaseHas('Media',[
            'postingan_id' => $data->postingan_id,
            'nama' => $data->nama,
            'jenis' => $data->jenis,
            'url' => $data->url,
            
        ]);
        //$response->assertStatus(200);
    }
}
