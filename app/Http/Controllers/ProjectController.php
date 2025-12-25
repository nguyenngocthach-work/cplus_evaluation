<?php
namespace App\Http\Controllers;

class ProjectController extends Controller
{
    public function index()
    {
        return view('manage_projects.manage_projects');
    }

    public function show($id)
    {
        return view('manage_projects.detail', [
            'criteriaLabels' => ['Traffic','Visibility','Accessibility'],
            'criteriaScores' => [8,7,9]
        ]);
    }
    public function create()
    {
        return view('manage_projects.manage_locations');
    }
    public function store()
    {
        return view('manage_projects.manage_locations');
    }
}