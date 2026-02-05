<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\PhotosLocation;

use App\Jobs\UploadLocationPhotosJob;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class LocationController extends Controller
{
    public function index(Request $request)
    {
        try{
            $data = $request->all();

            $validator = Validator::make($data,[
                'keyword' => 'nullable|string|max:255'
            ]);

            $list = Industry::with('photos')
                ->select(
                    'id',
                    'industry_name',
                    'description',
                    'street',
                    'city',
                    'state_province',
                    'zipcode',
                    'country',
                    'created_at',
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
                'photos' => 'nullable|array|max:7', // Giới hạn mảng tối đa 7 hình
                'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120', // Từng file phải là ảnh
                // sau khi develop xong phan user va photos thi mo lai
                // 'user_id' => 'required|numeric',
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

            $photoPaths = [];

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPaths[] = $photo->store(
                        'tmp/locations',
                        'public'
                    );
                }
            }

            if (!empty($photoPaths)) {
                UploadLocationPhotosJob::dispatch($location->id, $photoPaths);
            }

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

    public function update(Request $request){
        try{
            $data = $request->all();
            
            $validator = Validator::make($data,[
                'id' => 'required|numeric',
                'industry_name'   => 'required|string|max:255',
                'description'     => 'nullable|string',
                'street'          => 'required|string',
                'city'            => 'required|string',
                'state_province'  => 'nullable|string',
                'zipcode'         => 'nullable|string',
                'country'         => 'required|string',
                'delete_photos'   => 'array',
                'delete_photos.*' => 'numeric|exists:photos_location,img_id',
                'new_photos.*'   => 'image|mimes:jpg,jpeg,png|max:5120',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            
            $industry = Industry::findOrFail($request->input('id'));
            $industry->update([
                'industry_name'  => $request->industry_name,
                'description'    => $request->description,
                'street'         => $request->street,
                'city'           => $request->city,
                'state_province' => $request->state_province,
                'zipcode'        => $request->zipcode,
                'country'        => $request->country,
            ]);

            if (!empty($request->delete_photos)) {
                $photos = PhotosLocation::whereIn('img_id', $request->delete_photos)->get();

                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo->img_url);
                    $photo->forceDelete();
                } 
            }

            if ($request->hasFile('new_photos')) {
                foreach ($request->file('new_photos') as $file) {

                $directory = 'locations/' . $industry->id;

                $path = $file->store($directory, 'public');

                PhotosLocation::create([
                    'industry_id' => $industry->id,
                    'img_url'     => $path,
                ]);
            }
            }
            
            return redirect()
                ->route('locations.screen')
                ->with('success', 'Location updated successfully');

        } catch(\Exception $e){
            dd($e);
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to store location'], 400);
        }
    }

    public function search(Request $request){
        try{
            $request->validate([
                'keyword' => 'required|string|max:255',
            ]);

            $industry = Industry::where('industry_name', 'like', '%' . $request->keyword . '%')
                ->limit(10)
                ->get(['id', 'industry_name']);
            return response()->json($industry);
        } catch(\Exception $e){
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to store location'], 400);
        }
    }

    public function delete($id){
        try{
            $industry = Industry::with('photos')->findOrFail($id);
            $industry->delete();

            if($industry->photos){
                foreach($industry->photos as $photo){
                    // Delete photo file from storage
                    if (\Storage::disk('public')->exists($photo->img_url)) {
                        \Storage::disk('public')->delete($photo->img_url);
                    }
                }
            }
            return redirect()
                ->route('locations.screen')
                ->with('success', 'Location deleted successfully');
        } catch(\Exception $e){
            dd($e);
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to delete location'], 400);
        }
    }
}