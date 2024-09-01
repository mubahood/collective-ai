<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garden;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Utils;
use Illuminate\Support\Facades\Storage;

class GardenController extends Controller
{
    public function index()
    {
        $gardens = Garden::all();
        return response()->json($gardens);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->all();
        
        // Store the uploaded photo
        if ($request->has('photo')) {
            $photoData = $request->input('photo');
            list($type, $photoData) = explode(';', $photoData);
            list(, $photoData) = explode(',', $photoData);
            $photoData = base64_decode($photoData);
        
            $photoPath = 'images/' . uniqid() . '.jpg'; 
            Storage::disk('admin')->put($photoPath, $photoData);
            
            $data['photo'] = $photoPath;
        }
    
    
        $garden = Garden::create($data);
        return Utils::success($garden, 'Garden submitted successfully.');
    }
    

    public function show($id)
    {
        $garden = Garden::where('user_id', $id)->firstOrFail();

        return response()->json($garden);
    }

    public function update(Request $request, $id)
    {
        $garden = Garden::where('user_id', $id)->firstOrFail();

        $data = $request->all();

         // Store the uploaded photo
         if ($request->has('photo')) {
            $photoData = $request->input('photo');
            list($type, $photoData) = explode(';', $photoData);
            list(, $photoData) = explode(',', $photoData);
            $photoData = base64_decode($photoData);
        
            $photoPath = 'images/' . uniqid() . '.jpg'; 
            Storage::disk('admin')->put($photoPath, $photoData);
            
            $data['photo'] = $photoPath;
        }
    
        $garden->update($data);
        return Utils::success($garden, 'Garden edited successfully.');
    }

    public function destroy($id)
    {
        $garden = Garden::where('user_id', $id)->firstOrFail();
        $garden->delete();
        return Utils::success($garden, 'Garden deleted successfully.');
    }
}
