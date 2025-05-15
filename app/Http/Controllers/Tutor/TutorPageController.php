<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorPageController extends Controller
{
        public function index()
    {
        return view('tutor.home');
    }
}
