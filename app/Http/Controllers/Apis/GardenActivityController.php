<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GardenActivity;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Utils;
use Illuminate\Support\Facades\Storage;

class GardenActivityController extends Controller
{
    public function index()
    {
        $garden_activities = GardenActivity::all();
        return response()->json($garden_activities);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->all();
        
        $garden_activity = GardenActivity::create($data);
        return Utils::success($garden_activity, 'Garden Activity submitted successfully.');
    }
    

    public function show($id)
    {
        $garden_activity = GardenActivity::find($id);

        return response()->json($garden_activity);
    }

    public function update(Request $request, $id)
    {
        $garden_activity = GardenActivity::find($id);

        $data = $request->all();

        $garden_activity->update($data);
        return Utils::success($garden_activity, 'Garden Activity edited successfully.');
    }

    public function destroy($id)
    {
        $garden_activity = GardenActivity::find($id);
        $garden_activity->delete();
        return Utils::success($garden_activity, 'Garden Activity deleted successfully.');
    }
}
