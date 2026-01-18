<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function loginPage(){
        return view('admin.admin_login');
    }

    public function login(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
        // dd(User::where('username', $request->username)->first());
            
        $remember = $request->boolean('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.screen'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
        } catch (\Exception $e) {
            Log::error('login failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return back()->withErrors([
                'error' => 'An error occurred during login. Please try again later.',
            ])->withInput();
        }
    }
}