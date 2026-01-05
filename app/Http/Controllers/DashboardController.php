<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalClients = Client::count();
        $totalLocation = Industry::count();

        return view('admin.admin_dashboard', [
            'totalClients' => $totalClients,
            'totalLocation' => $totalLocation
        ]);
    }
}