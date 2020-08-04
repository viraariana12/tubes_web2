<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Postingan;
use App\Komentar;
//
class KomentarController extends Controller
{
    public function indexPostinganKomentar(Request $request, Postingan $postingan) {
        return $postingan->komenar();
    }

    public function indexUserKomentar(Request $request) {
        $user = $request->user();
        foreach ($user->komentar as $komentar) {
            $komentar->postingan;
        }
        
        return response()->json($user->komentar,200);
    }

    public function komentarPostingan(Request $request, Postingan $postingan) {
        $user = $request->user();
        
        $komentar = $user->komentar()->create($request->all());
        $komentar->postingan()->associate($postingan);
        $komentar->save();

        return response()->json($komentar,201);
    }

    public function perbaruiKomentar(Request $request, Komentar $komentar) {
        $user = $request->user();

        if ($komentar->user_id == $user->id) {
            $komentar->update($request->all());
            return response()->json($komentar,200);
        } else {
            return response()->json([
                "error" => "Tidak berhak mengubah komentar orang lain"
            ],422);
        }

    }

    public function hapusKomentar(Request $request, Komentar $komentar) {
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
