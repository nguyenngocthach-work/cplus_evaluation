<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

            $query = Project::with([
                'client:id,client_name',
                'industry:id,industry_name',
                'projectCriteria.criteria:id,criteria_name'
            ])
            ->select(
                'project_id',
                'project_name',
                'clientId',
                'industry_id',
                'start_date',
                'end_date',
                'created_at'
            );

            if (!empty($data['keyword'])) {
                $query->where('project_name', 'like', '%' . $data['keyword'] . '%');
            }

            $projects = $query
                ->orderBy('created_at', 'desc')
                ->paginate(4);

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
        $criteria = Criteria::select(
            'id',
            'criteria_name',
            'criteriaPercent',
            'description'
        )
        ->orderBy('created_at', 'desc')
        ->get();

        return view('project.project_add', compact('criteria'));
    }
    
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'description'  => 'nullable|string',
                'start_date'   => 'required|date',
                'end_date'     => 'required|date|after_or_equal:start_date',
                'criteria_ids' => 'required|array',
                'criteria_ids.*' => 'exists:criteria,id',
            ]);
            // sau khi xong auth sẽ gởi user id từ view về
            $userId = 2;

            $project = Project::create([
                'project_name' => $request->project_name,
                'description'  => $request->description,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'userId'       => $userId,
                'clientId'     => $request->clients[0] ?? null,
                'industry_id'  => $request->locations[0] ?? null,
            ]);

            $criteriaData = [];
            if ($request->has('criteria_ids')) {
                foreach ($request->criteria_ids as $id) {
                    $criteriaData[$id] = [
                        'weight' => $request->criteria_percent[$id] ?? 0,
                        'custom_description' => $request->criteria_description[$id] ?? '',
                    ];
                }
                
                $project->criteria()->sync($criteriaData);
            }

            $project->criteria()->sync($criteriaData);

            $project->clientId = $request->clients[0] ?? null;
            $project->industry_id = $request->locations[0] ?? null;
            $project->save();
            
            return redirect()->route('project.project');
        } catch(\Exception $e){
            dd([
                'message'  => $e->getMessage(),
                'sql'      => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
            Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'Line' => $e->getLine(),
                'File' => $e->getFile()
            ]);
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function exportProjectList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'keyword' => 'nullable|string|max:255',
        ]);
        
        $list = Project::with([
            'client:id,client_name',
            'industry:id,industry_name',
        ])
        ->select(
            'project_id',
            'project_name',
            'clientId',
            'industry_id',
            'start_date',
            'end_date',
            'created_at'
        );
        if (!empty($data['keyword'])) {
            $list->where('project_name', 'like', '%' . $data['keyword'] . '%');
        }

        $projects = $list
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'project' . now()->format('Ymd_His') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($projects) {
            $handle = fopen('php://output', 'w');
            
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Project Name',
                'Project ID',
                'Client Name',
                'Industry',
                'Start Date',
                'End Date',
            ]);

            foreach ($projects as $project) {
                fputcsv($handle, [
                    $project->project_name,
                    $project->id,
                    $project->client->client_name ?? '-',
                    $project->industry->industry_name ?? '-',
                    optional($project->start_date)
                        ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y')
                        : '',
                    optional($project->end_date)
                        ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y')
                        : '',
                ]);
            }

            fclose($handle);
        };
        
        return new StreamedResponse($callback, 200, $headers);
    }

    public function delete($project_id)
    {
        try{
            $project = Project::findOrFail($project_id);
            // dd($project);
            $project->delete();

            return redirect()
                ->route('projects.screen')
                ->with('success', 'Project deleted successfully.');
        } catch(\Exception $e){
            dd($e);
            Log::error('Delete project failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Delete project failed.');
        }
    }
}