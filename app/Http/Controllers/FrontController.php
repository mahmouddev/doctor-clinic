<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Foundation\Application;

class FrontController extends Controller
{

    public function index(Request $request)
    {
        if(Auth::check()){
            return redirect(route('admin.index'));
        }else{
            return redirect(route('login'));
        }
    }
}
