<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Postingan;
use App\User;
use Illuminate\Http\Request;

class UserPostinganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        //return 
        $daftarPostingan = $user->postingan()->with('user:id,nama,foto')->get();
        
        $keluaran = [];

        foreach ($daftarPostingan as $postingan) {

            $user = $request->user();
            $suka = null;

            if ($user) {
                $suka = $user->like()
                            ->where('postingan_id',$postingan->id)
                            ->first();
                if ($suka) {
                    $suka = $suka->id;
                }
            }

            $jumlahSuka = $postingan->like()->count();
            $jumlahKomentar = $postingan->komentar()->count();

            $data = [
                "suka" => $suka,
                "jumlahSuka" => $jumlahSuka,
                "jumlahKomentar" => $jumlahKomentar
            ];

            $postingan = $postingan->toArray();

            $postingan["data"] = $data;

            array_push($keluaran,$postingan);
        }
        return response()->json($keluaran,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'isi' => 'required',
            'media.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);
        
        }
        
        $user = $request->user();
        $postingan = $user->postingan()->create($request->except('media'));

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $url = $media->store('public');
                $postingan->media()->create([
                    "nama" => $media->getClientOriginalName(),
                    "url" => $url,
                    "jenis" => "foto"
                ]);
            }
        }
        $id = $postingan->id;

        $ret = Postingan::with('user:id,nama,foto')->where('id','=',$id)->get();
        return response()->json($ret[0],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Postingan  $postingan
     * @return \Illuminate\Http\Response
     */
    public function show(Postingan $postingan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Postingan  $postingan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Postingan $postingan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postingan  $postingan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Postingan $postingan)
    {
        //
    }
}
