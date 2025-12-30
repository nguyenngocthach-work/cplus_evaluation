<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {   
        try{
            $data = $request->all();

            $validator = Validator::make($data, [
                'page' => 'nullable|numeric|min:1',
                'keyword' => 'nullable|string|max:255',
            ]);

            $list = Project::select(
                'id',
                'project_name',
                'clientId',
                'industry_id',
                'start_day',
                'end_day',
            );
        
            if(!empty($data['keyword'])){
                $keyword = $data['keyword'];
                $list->where('project_name', 'like', "%{$keyword}%");
            }

            $projects = $list->orderBy('created_at', "desc")->paginate(4);

            return view('project.project', compact('projects'));
        } catch(\Exception $e){
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to fetch projects'], 400);
        }
    }

    public function show()
    {

    }
    public function create()
    {
        return view('project.project_add');
    }
    public function store()
    {
        return view('project.project');
    }
}