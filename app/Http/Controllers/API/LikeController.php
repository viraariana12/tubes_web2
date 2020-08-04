<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Postingan;
use App\Like;
use App\User;

class LikeController extends Controller
{
    

    public function indexPostinganLike(Postingan $postingan) {
        foreach ($postingan->like as $like) {
            $like->user;
        }
        return response()->json($postingan->like,200);
    }

    public function indexUserLike(Request $request) {
        $user = $request->user();
        foreach ($user->like as $like) {
            $like->postingan;
        }
        return response()->json($user->like,200);
    }

    public function like(Request $request, Postingan $postingan) {
        $user = $request->user();
        $error = $user->like()->where('postingan_id',$postingan->id)->first();
        
        if ($error) {
            
            return response()->json([
                "error" => "Sudah disukai"
            ],422);

        } else {
            
            $like = $user->like()->create();
            $like->postingan()->associate($postingan);
            $like->save();

            return response()->json($like,200);
        }
    }

    public function unlike(Request $request, Postingan $postingan) {
        $user = $request->user();
        $ada = $user->like()->where('postingan_id',$postingan->id)->first();
        if ($ada) {
            $ada->delete();
            return response()->json(null,204);
        } else {
            return response()->json([
                "error" => "Belum disukai"
            ],422);
        }
    }
}
