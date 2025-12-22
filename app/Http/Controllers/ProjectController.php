<?php
namespace App\Http\Controllers;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index');
    }

    public function show($id)
    {
        return view('projects.detail', [
            'criteriaLabels' => ['Traffic','Visibility','Accessibility'],
            'criteriaScores' => [8,7,9]
        ]);
    }
}
