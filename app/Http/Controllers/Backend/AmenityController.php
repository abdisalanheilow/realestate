<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function AllAmenity()
    {
        $amenities = Amenity::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    } // End Method 

    public function AddAmenity()
    {
        return view('backend.amenities.add_amenities');
    } // End Method

    public function StoreAmenity(Request $request)
    {
        $request->validate([
            'amenity_name' => 'required|unique:amenities|max:200',
        ]);

        Amenity::insert([
            'amenity_name' => $request->amenity_name,
        ]);

        $notification = array(
            'message' => 'Amenity Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenity')->with($notification);
    } // End Method

    public function EditAmenity($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('backend.amenities.edit_amenities', compact('amenity'));
    } // End Method

    public function UpdateAmenity(Request $request)
    {
        $amenity_id = $request->id;

        Amenity::findOrFail($amenity_id)->update([
            'amenity_name' => $request->amenity_name,
        ]);

        $notification = array(
            'message' => 'Amenity Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenity')->with($notification);
    } // End Method

    public function DeleteAmenity($id)
    {
        Amenity::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenity Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
}
