<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\TmRole;
use function GuzzleHttp\json_encode;
use Session;
use API;
use AccessRight;

class ProfileController extends Controller
{

    public function index()
    {
        if (empty(Session::get('authenticated')))
            return redirect('/login');
            

        $profile = AccessRight::profile();
        return view('profile')->with(compact('profile'));
    }

}
