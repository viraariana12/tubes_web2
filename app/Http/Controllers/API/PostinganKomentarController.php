<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Komentar;
use App\Postingan;
use Illuminate\Http\Request;

class PostinganKomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Postingan $postingan)
    {
        /*$ret = array();
        foreach ($postingan->komentar as $komentar) {
            $tmp = [
                "id" => $komentar->id,
                "userId" => $komentar->user_id,
                "nama" => $komentar->user->nama,
                "isi" => $komentar->isi,
                "foto" => $komentar->user->foto
            ];
            array_push($ret,$tmp);
        }*/
        return response()->json($postingan->komentar()
                                            ->with('user:id,nama,foto')
                                            ->get(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Postingan $postingan)
    {
        $user = $request->user();
        
        $komentar = $user->komentar()->create($request->all());
        $komentar->postingan()->associate($postingan);
        $komentar->save();

        $id = $komentar->id;
        $ret = Komentar::with('user:id,nama,foto')->where('id','=',$id)->get();

        return response()->json($ret[0],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function show(Komentar $komentar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Komentar $komentar)
    {
        $user = $request->user();

        if ($komentar->user_id == $user->id) {
            $komentar->update($request->all());
            $komentar = Komentar::with('user:id,nama,foto')->where('id','=',$komentar->id)->get();

            return response()->json($komentar[0],200);
        } else {
            return response()->json([
                "error" => "Tidak berhak mengubah komentar orang lain"
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Komentar  $komentar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Komentar $komentar)
    {
        $user = $request->user();
        $postingan_userid = $komentar->postingan->user_id;
        if ($postingan_userid == $user->id) {
            $komentar->delete();
            return response()->json(null,204);
        } else if ($komentar->user_id == $user->id) {
            $komentar->delete();
            return response()->json(null,204);
        } else {
            return response()->json([
                "error" => "Tidak dapat menghapus komentar orang lain yang bukan di Postingan sendiri"
            ],422);
        } 
    }
}
