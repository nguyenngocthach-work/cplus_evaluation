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
    return view('evaluations.evaluations');
  } 
  public function create()
  {
    return view('evaluations.evaluations');
  }
  public function store()
  {
    return view('evaluations.evaluations');
  }  
}