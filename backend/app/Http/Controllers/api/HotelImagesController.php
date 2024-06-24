<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HotelImagesController extends Controller
{
    public function index(Hotel $hotel){
        $images = $hotel->images()->get();
        return response()->json($images,200);
    }
    public function store(Request $request, Hotel $hotel)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotel_images', 'public');

            $image = new HotelImage();
            $image->hotel_id = $hotel->id;
            $image->image = $imagePath;
            $image->save();

            return response()->json($image, 201);
        } else {
            return response()->json(['error' => 'No image uploaded'], 400);
        }
    }

    public function show(HotelImage $image)
    {
        return response()->json($image, 200);
    }

    public function update(Request $request, HotelImage $image)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Check if a new image file is uploaded
    if ($request->hasFile('image')) {
        // Store the new image file
        $newImagePath = $request->file('image')->store('hotel_images', 'public');

        // Delete the old image file if it exists
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        // Update the image path in the database
        $image->update(['image' => $newImagePath]);
    }

    // Update other fields if present, excluding the image field
    $image->update($request->except(['image']));

    // Return the updated image data
    return response()->json($image, 200);
}
    public function destroy(HotelImage $image)
{
    // Check if the image file exists in the storage
    if (Storage::disk('public')->exists($image->image)) {
        // Delete the image file from storage
        Storage::disk('public')->delete($image->image);
    }

    // Delete the record from the database
    $image->delete();

    // Return a success response
    return response()->json(['message' => 'Image deleted successfully'], 200);
}

}