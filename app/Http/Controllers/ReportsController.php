<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClientLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('evaluation_report.evaluation_report');
    } 
    public function create()
    {
        return view('evaluation_report.evaluation_report');
    }
    public function store()
    {
        return view('evaluation_report.evaluation_report');
    }  
}