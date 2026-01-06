<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalClients = Client::count();
        $totalLocation = Industry::count();
        $totalProject = Project::count();

        $query = Project::with([
            'client:id,client_name',
            'industry:id,industry_name'
        ])
        ->select(
            'project_id',
            'project_name',
            'clientId',
            'industry_id',
            'end_date',
            'status'
        );

        $activeProjectList = $query
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // dd($activeProjectList);
        return view('admin.admin_dashboard', [
            'totalClients' => $totalClients,
            'totalLocation' => $totalLocation,
            'totalProject' => $totalProject,
            'activeProjectList' => $activeProjectList
        ]);
    }
}