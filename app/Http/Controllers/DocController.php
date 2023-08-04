<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocController extends Controller
{
    function api_doc(){
        return view('doc');
    }
}
