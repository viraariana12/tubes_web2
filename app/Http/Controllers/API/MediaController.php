<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Media;
use App\User;
use App\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Postingan $postingan)
    {
        return response()->json($postingan->media,200);
    }


    public function indexMediaUser(User $user) {
        $return_arr = array();
        $postingan_user = $user->postingan;
        foreach ($postingan_user as $posting) {
            foreach ($posting->media as $media) {
                array_push($return_arr,$media);
            }
        }
        return response()->json($return_arr,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Postingan $postingan, Request $request)
    {
        $user = $request->user();
        if ($user->id == $postingan->user_id) {
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $media) {
                    $url = $media->store('public');
                    $postingan->media()->create([
                        "nama" => $media->getClientOriginalName(),
                        "url" => $url,
                        "jenis" => "foto"
                    ]);
                }
                return response()->json($postingan->media,201);
            }
        } else {
            return response()->json([
                "error" => "Tidak diperbolehkan"
            ],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Media $media)
    {
        $user = $request->user();
        if ($media->postingan->user_id == $user->id) {
            Storage::delete($media->url);
            $media->delete();
            return response()->json(null,204);
        } else {
            return response()->json([
                "error" => "Tidak berhak"
            ],403);
        }
    }
}
