<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('manage_clients.manage_clients');
    }

    public function create()
    {
        return view('client_create.client_create');
    }

    public function store(Request $request)
    {
        // xử lý lưu sau
        // dd('ok', $request->all());

        return redirect()->route('admin.clients');

    }
} 