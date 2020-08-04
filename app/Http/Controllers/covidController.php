<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class covidController extends Controller
{
    public function index(){
    	$covid=Http::get('https://data.covid19.go.id/public/api/prov.json');
    	$data=$covid->json();
    	dd($data);
    }
}
