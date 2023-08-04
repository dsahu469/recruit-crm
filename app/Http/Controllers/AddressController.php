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

use App\Models\Address;

class AddressController extends Controller
{
    function show($id = null){
        if($id){
            $addresses = Address::findOrFail($id);
        }else{
            $addresses = Address::all();
        }

        return response()->json(['data' => $addresses], 200);
    }

    function store(Request $request){
        $validator = Validator::make($request->all(), [
            'country'        => 'required|string',
            'street_address' => 'required|string',
            'city'           => 'required|string',
            'state'          => 'required|string',
            'postal_code'    => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }else{
            $address = new Address();
            $address->id             = Str::uuid(); // Generate a UUID
            $address->country        = $request->country;
            $address->street_address = $request->street_address;
            $address->city           = $request->city;
            $address->state          = $request->state;
            $address->postal_code    = $request->postal_code;

            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Address Saved Successfully'
            ], 200);
        }
    }
}
