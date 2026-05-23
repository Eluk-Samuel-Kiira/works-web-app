<?php

namespace App\Http\Controllers\JS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MainApiService;

class CVController extends Controller
{
    public function edit()
    {
        return view('seeker.cv-edit');
    }
    
    public function editorComponent()
    {
        if (!request()->ajax()) {
            abort(404);
        }
        return view('job-seeker.cv-editor-component');
    }
}
