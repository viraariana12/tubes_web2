<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Media;
use App\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostinganMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Postingan $postingan)
    {
        return $postingan->media;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Postingan $postingan)
    {
        $ret = [];
        $user = $request->user();
        if ($user->id == $postingan->user_id) {
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $media) {
                    $url = $media->store('public');
                    $data = $postingan->media()->create([
                        "nama" => $media->getClientOriginalName(),
                        "url" => $url,
                        "jenis" => "foto"
                    ]);
                    array_push($ret,$data);
                }
                return response()->json($ret,201);
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
    public function show(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $media)
    {
        $user = $request->user();
        $media = Media::find($media);
        
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
