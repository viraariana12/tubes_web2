<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::all();
    }

    public function infoLogin(Request $request) {
        
        $user = $request->user();

        /*return [
            "id" => $user->id,
            "nama" => $user->nama,
            "email" => $user->email,
            "foto" => $user->foto
        ];*/
        return $user;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|unique:App\User,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        } else {

            $user = User::create($request->except('password','foto'));

            if ($request->hasFile('foto')) {
                $path = $request->foto->store('public');
                $user->foto = $path;
            }

            $user->password = Hash::make($request->password);
            $user->api_token = Str::random(40);
            $user->save();

            $ret = [   
                "user" => $user,
                "token" => $user->api_token
            ];

            return response()->json($ret,201);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request) {

        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        } else {

            $user = User::where('email',$request->email)->first();

            if ($user) {
                if (Hash::check($request->password,$user->password)) {
                    $user->api_token = Str::random(40);
                    $user->save();

                    $ret = [   
                        "user" => $user,
                        "token" => $user->api_token
                    ];

                    return $ret;

                } else {
                    return response()->json([
                        "password" => ["Password salah"]
                    ],422);
                }
            } else {
                return response()->json([
                    "email" => ["E-Mail tidak terdaftar"]
                ],422);
            }

        }
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = $request->user();

        $user->update($request->except('password','foto'));
        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public');
            $user->foto = $path;
        }
        if ($request->has('password')) {
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
        }
        $user->save();
        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $user = $request->user();

        $user->api_token = null;
        $user->save();

        return response()->json(null,204);
    }

    public function destroy(Request $request, User $user)
    {
        $user = $request->user();
        foreach ($user->postingan as $postingan) {
            foreach ($postingan->media as $media) {
                Storage::delete($media->url);
                $media->delete();
            }
            foreach ($postingan->like as $like) {
                $like->delete();
            }
            foreach ($postingan->komentar as $komentar) {
                $komentar->delete();
            }
        }
        foreach ($user->like as $like) {
            $like->delete();
        }
        foreach ($user->komentar as $komentar) {
            $komentar->delete();
        }
        $user->delete();
    }
}
