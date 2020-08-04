<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Postingan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostinganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return Postingan::with('user:id,nama,foto')->latest()->get();
        $daftarPostingan = Postingan::with('user:id,nama,foto')->latest()->get();
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

    public function store(Request $request) {
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
        $ret = $ret[0]->toArray();

        $ret['data'] = [
            "suka" => null,
            "jumlahSuka" => 0,
            "jumlahKomentar" => 0
        ];

        return response()->json($ret,201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Postingan  $postingan
     * @return \Illuminate\Http\Response
     */
    public function show(Postingan $postingan)
    {
        return response()->json($postingan,200);
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
        $user = $request->user();
        if ($user->id == $postingan->user_id) {
            $postingan->update($request->all());

            $postingan = Postingan::with('user:id,nama,foto')->where('id','=',$postingan->id)->get()[0];

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

            return response()->json($postingan,200);

        } else {
            return response()->json([
                "error" => "Tidak diijinkan"
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postingan  $postingan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Postingan $postingan)
    {
        $user = $request->user();

        if ($user->id == $postingan->user_id) {
            foreach($postingan->media as $media) {
                Storage::delete($media->url);
                $media->delete();
            }
            foreach($postingan->like as $like) {
                $like->delete();
            }
            foreach($postingan->komentar as $komentar) {
                $komentar->delete();
            }

            $postingan->delete();

            return response()->json(null,204);
        } else {
            return response()->json([
                "error" => "Tidak diijinkan"
            ],403);
        }

    }
}
