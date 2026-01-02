<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Criteria;

class CriteriaController extends Controller
{
  // not used
  public function index()
  {
    try{
      $criteria = Criteria::select(
        'id',
        'criteria_name',
        'criteriaPercent',
        'description'
      )
      ->orderBy('created_at', 'desc')
      ->get();

      return view('project.project_add', compact('criteria'));
    } catch(\Exception $e){
      Log::error('Error in: ' . __METHOD__, [
        'message' => $e->getMessage(),
        'Line' => $e->getLine(),
        'File' => $e->getFile()
      ]);
      return response()->json(['error' => 'Failed to fetch clients'], 400);
    }
  }
}