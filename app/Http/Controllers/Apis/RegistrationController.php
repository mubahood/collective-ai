<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Utils;

class  RegistrationController extends Controller
{
    public function index()
    {
        $Registrations = Registration::all();
        return response()->json($Registrations);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->all();
        $Registration = Registration::create($data);
        return Utils::success($Registration, 'Registration form submitted successfully.');
    }

    public function show($id)
    {
        $Registration = Registration::where('user_id', $id)->firstOrFail();

        return response()->json($Registration);
    }

    public function update(Request $request, $id)
    {
        $Registration = Registration::where('user_id', $id)->firstOrFail();
        // Check if the Registration exists
        if (!$Registration) {
            return Utils::error('Registration not found.', 404);
        }
        $data = $request->all();
        $Registration->update($data);
        return Utils::success($Registration, 'Registration form edited successfully.');
    }

    public function destroy($id)
    {
        $Registration = Registration::where('user_id', $id)->firstOrFail();
        $Registration->delete();
        return Utils::success($Registration, 'Registration form deleted successfully.');
    }
}
