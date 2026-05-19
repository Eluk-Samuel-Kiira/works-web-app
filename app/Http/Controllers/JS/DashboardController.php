<?php

namespace App\Http\Controllers\JS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function seekerDashboard()
    {
        $user = session('web_user');
        return view('job-seeker.dashboard', ['user' => $user]);
    }
}
