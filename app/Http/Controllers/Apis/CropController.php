<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Utils;
use Illuminate\Support\Facades\Storage;

class  CropController extends Controller
{
    public function index()
    {
        $crops = Crop::all();
        return response()->json($crops);
    }


    public function store(Request $request)
    {
        $user = auth('api')->user();

        // Extract activities data from the request
        $activities = $request->input('activities', []);


        // Create the Crop model with the uploaded photo path
        $data = [
            'name' => $request->input('name'),
            'details' => $request->input('details'),
        ];

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

        $crop = Crop::create($data);

        foreach ($activities as $activity) {
            $pivotData = [
                'crop_id' => $crop->id,
                'name' => $activity['name'],
                'step' => $activity['step'],
                'value' => $activity['value'],
                'is_before_planting' => $activity['is_before_planting'],
                'days_before_planting' => $activity['days_before_planting'],
                'days_after_planting' => $activity['days_after_planting'],
                'acceptable_timeline' => $activity['acceptable_timeline'],
                'is_activity_required' => $activity['is_activity_required'],
                'details' => $activity['details'],
            ];

            // Attach activities to the crop using the pivot table
            $crop->activities()->create($pivotData);
        }

        return Utils::success($crop, 'Crop form submitted successfully.');
    }




    public function show($id)
    {
        // Retrieve the crop with the specified ID along with its associated activities
        $crop = Crop::with('activities')->find($id);

        if (!$crop) {
            return Utils::error('Crop not found.', 404);
        }

        return Utils::success($crop, 'Crop retrieved successfully.');
    }



    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        $data = [
            'name' => $request->input('name'),
            'details' => $request->input('details'),
        ];


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


        // Find the crop with the specified ID
        $crop = Crop::find($id);

        if (!$crop) {
            return Utils::error('Crop not found.', 404);
        }

        // Update the Crop model with the updated data
        $crop->update($data);

        // Update the activities associated with the crop (if needed)
        $activities = $request->input('activities', []);
        $crop->activities()->delete(); // Delete existing activities
        foreach ($activities as $activity) {
            $pivotData = [
                'crop_id' => $crop->id,
                'name' => $activity['name'],
                'step' => $activity['step'],
                'value' => $activity['value'],
                'is_before_planting' => $activity['is_before_planting'],
                'days_before_planting' => $activity['days_before_planting'],
                'days_after_planting' => $activity['days_after_planting'],
                'acceptable_timeline' => $activity['acceptable_timeline'],
                'is_activity_required' => $activity['is_activity_required'],
                'details' => $activity['details'],
            ];
            $crop->activities()->create($pivotData);
        }

        return Utils::success($crop, 'Crop updated successfully.');
    }


    public function destroy(Crop $crop)
    {
        // Delete the crop
        $crop->delete();

        // You can also delete associated activities here if needed
        $crop->activities()->delete();

        return Utils::success(null, 'Crop deleted successfully.');
    }
}
