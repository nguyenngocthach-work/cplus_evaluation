<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index()
    {
        return view('manage_locations.manage_locations');
    } 
    public function create()
    {
        return view('manage_locations.manage_locations');
    }
    public function store()
    {
        return view('manage_locations.manage_locations');
    }  
}