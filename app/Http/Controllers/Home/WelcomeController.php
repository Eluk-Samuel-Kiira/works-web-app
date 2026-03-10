<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get URL from config
        $mainAppUrl = config('api.main_app.api_base');
        
        // Get data from main app
        $response = Http::get($mainAppUrl . '/user-data');
        
        // Convert to array
        $data = $response->json();
        // dd($data);
        
        // Pass to view
        return view('home.welcome', $data);
    }


}