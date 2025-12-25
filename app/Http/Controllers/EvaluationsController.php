<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EvaluationsController extends Controller
{
  public function index()
  {
    return view('manage_evaluations.manage_evaluations');
  } 
  public function create()
  {
    return view('manage_evaluations.manage_evaluations');
  }
  public function store()
  {
    return view('manage_evaluations.manage_evaluations');
  }  
}