<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        try{
            $data = $request->all();

            $validator = Validator::make($data,[
                'keyword' => 'nullable|string|max:255'
            ]);

            $list = Industry::select(
                'id',
                'industry_name',
                'description',
                'street',
                'city',
                'state_province',
                'zipcode',
                'country'
            );

            if (!empty($data['keyword'])) {
                $keyword = $data['keyword'];
                $list->where('industry_name', 'like', "%{$keyword}%");
            }

            $locations = $list->orderBy('created_at', "desc")->get();
            return view('locations.locations', compact("locations")); 
        } catch (\Exception $e){
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to fetch location'], 400);
        }
        
    } 
    public function create()
    {
        return view('locations.locations_add');
    }
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'industry_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'street' => 'required|string|max:500',
                'city' => 'required|string|max:100',
                'state_province' => 'required|string|max:100',
                'zipcode' => 'required|string|max:20',
                'country' => 'required|string|max:100',
                // sau khi develop xong phan user va photos thi mo lai
                // 'user_id' => 'required|numeric',
                // 'photos_link' => 'required|string',
            ]);

            $user_id = 2; // to be removed later
            $data['user_id'] = $user_id;
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $location = new Industry();
            $location->industry_name = $data['industry_name'];
            $location->description = $data['description'];
            $location->street = $data['street'];
            $location->city = $data['city'];
            $location->state_province = $data['state_province'];
            $location->zipcode = $data['zipcode'];
            $location->country = $data['country'];
            $location->user_id = $data['user_id'];

            $location->save();
            return redirect()->route('locations.screen')->with('success', 'Location created successfully.');   
        } catch (\Exception $e) {
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to store location'], 400);
        }
    }  

    public function update(){
        
    }
}