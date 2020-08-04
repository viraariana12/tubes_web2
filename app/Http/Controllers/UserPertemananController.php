<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserPertemananController extends Controller
{
    public function index(Request $request, User $user)
    {
    	return $user->teman;
    }
	
	public function store(Request $request, User $user)
    {
    	$userLogin=$request->user();
    	$userLogin->teman()->attach($user);
    	return $userLogin->teman;
    }

    public function destroy(Request $request, $user)
    {
    	$userLogin=$request->user();
    	$mUser = User::find($user);
    	$userLogin->teman()->detach($mUser);
    	return null;
    }

}
