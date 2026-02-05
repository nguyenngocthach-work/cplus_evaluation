<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Criteria;

class CriteriaController extends Controller
{
  public function index(Request $request)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'page' => 'nullable|numeric|min:1',
        'keyword' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
      }

      $query = Criteria::query()
        ->whereNull('parentId')
        ->select(
          'id',
          'criteria_name',
          'criteriaPercent',
          'description',
          'created_at',
        );

      if (!empty($data['keyword'])) {
        $query->where('criteria_name', 'like', '%' . $data['keyword'] . '%');
      }

      $query->withCount('children');

      $criteria = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      return view('criteria.criteria', compact('criteria'));
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to fetch criteria'], 400);
    }
  }

  public function show($groupId)
  {
    try {
      $group = Criteria::whereNull('parentId')->findOrFail($groupId);

      $children = Criteria::query()
        ->where('parentId', $groupId)
        ->with('type:id,name') // lấy criteria_type.name
        ->select('id', 'criteria_name', 'criteriaTypeId', 'parentId', 'criteriaPercent', 'description', 'created_at')
        ->orderBy('created_at', 'asc')
        ->get();

      return view('criteria.criteria-detail', compact('group', 'children'));
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to fetch criteria group'], 400);
    }
  }
  public function store(Request $request)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'criteriaPercent' => 'required|numeric|min:0|max:100',
        'description' => 'nullable|string',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $criteria = Criteria::create([
        'criteria_name' => $data['criteria_name'],
        'criteriaPercent' => $data['criteriaPercent'],
        'description' => $data['description'] ?? null,
      ]);

      $criteria->save();

      return redirect()->route('criteria.screen')->with('success', 'Criteria created successfully');
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to store criteria'], 400);
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'criteriaPercent' => 'required|numeric|min:0|max:100',
        'description' => 'nullable|string',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $criteria = Criteria::findOrFail($id);
      $criteria->criteria_name = $data['criteria_name'];
      $criteria->criteriaPercent = $data['criteriaPercent'];
      $criteria->description = $data['description'] ?? null;
      $criteria->save();

      return redirect()->route('criteria.screen')->with('success', 'Criteria updated successfully');
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to update criteria'], 400);
    }
  }
}