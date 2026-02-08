<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Criteria;
use App\Models\CriteriaType;

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
        ->paginate(5);

      $types = CriteriaType::select('id', 'name')->orderBy('name')->get();
      return view('criteria.criteria', compact('criteria', 'types'));
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to fetch criteria'], 400);
    }
  }

  public function show($groupId, Request $request)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'page' => 'nullable|numeric|min:1',
        'keyword' => 'nullable|string|max:255',
      ]);

      $group = Criteria::whereNull('parentId')->findOrFail($groupId);
      
      $children = Criteria::query()
        ->where('parentId', $groupId)
        ->with('type:id,name') // lấy criteria_type.name
        ->select('id', 'criteria_name', 'criteriaTypeId', 'parentId', 'criteriaPercent', 'description', 'created_at')
        ->orderBy('created_at', 'desc');

      if (!empty($data['keyword'])) {
        $children->where('criteria_name', 'like', '%' . $data['keyword'] . '%');
      }

      $children = $children->paginate(5)->withQueryString();
      $types = CriteriaType::select('id', 'name')->orderBy('name')->get();

      return view('criteria.criteria_group', compact('group', 'children', 'types'));
    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return redirect()
      ->route('criteria.screen')
      ->with('error', 'Failed to fetch criteria group');
      }
  }
  public function storeGroup(Request $request)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'description' => 'nullable|string',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $criteria = Criteria::create([
        'criteria_name' => $data['criteria_name'],
        'description' => $data['description'] ?? null,
        'parentId' => null,
        'criteriaTypeId' => null,
        'criteriaPercent' => null,
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

  public function storeChild(Request $request, $groupId)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'criteriaTypeId' => 'required|numeric|exists:criteria_type,id',
        'criteriaPercent' => 'required|numeric|min:0|max:100',
        'description' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      // đảm bảo group tồn tại
      $group = Criteria::whereNull('parentId')->findOrFail($groupId);

      Criteria::create([
        'criteria_name' => $data['criteria_name'],
        'criteriaTypeId' => $data['criteriaTypeId'],
        'parentId' => $group->id,
        'criteriaPercent' => $data['criteriaPercent'],
        'description' => $data['description'] ?? null,
      ]);

      return redirect()
        ->route('criteria.detail', $group->id)
        ->with('success', 'Criteria child created successfully');

    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);

      return redirect()->back()->with('error', 'Failed to store criteria child');
    }
  }

  public function updateGroup(Request $request, $id)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'description' => 'nullable|string',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $group = Criteria::whereNull('parentId')->findOrFail($id);

      $group->criteria_name = $data['criteria_name'];
      $group->description = $data['description'] ?? null;
      $group->save();

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

  public function updateChild(Request $request, $id)
  {
    try {
      $data = $request->all();

      $validator = Validator::make($data, [
        'criteria_name' => 'required|string|max:255',
        'criteriaTypeId' => 'required|numeric|exists:criteria_type,id',
        'criteriaPercent' => 'required|numeric|min:0|max:100',
        'description' => 'nullable|string|max:255',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $child = Criteria::whereNotNull('parentId')->findOrFail($id);

      $child->criteria_name = $data['criteria_name'];
      $child->criteriaTypeId = $data['criteriaTypeId'];
      $child->criteriaPercent = $data['criteriaPercent'];
      $child->description = $data['description'] ?? null;
      $child->save();

      return redirect()
        ->route('criteria.detail', $child->parentId)
        ->with('success', 'Criteria child updated successfully');

    } catch (\Exception $e) {
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);

      return redirect()->back()->with('error', 'Failed to update criteria child');
    }
  }

}