<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Currency;

class CurrencyController extends Controller
{
    function show($id = null){
        if($id){
            $currency = Currency::findOrFail($id);
        }else{
            $currency = Currency::all();
        }

        return response()->json(['data' => $currency], 200);
    }

    function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:currency_t',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }else{
            $currency = new Currency();
            $currency->id   = Str::uuid(); // Generate a UUID
            $currency->code = $request->code;

            $currency->save();

            return response()->json([
                'success' => true,
                'message' => 'Currency Saved Successfully'
            ], 200);
        }
    }
}
