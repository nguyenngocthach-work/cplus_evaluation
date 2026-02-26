<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Criteria;
use App\Models\Judgment;
use App\Models\JudgmentDetail;
use App\Models\ProjectIndustry;
use App\Models\Industry;
use App\Models\Client;
use App\Models\ProjectCriteria;
use App\Models\ProjectCriteriaTarget;
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
                'industries:id,industry_name',
                'projectCriteria.criteria:id,criteria_name'
            ])
            ->select(
                'project_id',
                'project_name',
                'clientId',
                'start_date',
                'end_date',
                'description',
                'status',
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
        $criteria = Criteria::with([
            'children', 
            'children.type:id,name'
        ])
        ->orderBy('created_at', 'desc')
        ->whereNull('parentId')
        ->get();

        $locations = Industry::all();
        $client = Client::all();

        return view('project.project_add', compact('criteria', 'locations', 'client'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'project_name'    => 'required|string|max:255',
                'description'     => 'nullable|string',
                'start_date'      => 'required|date',
                'end_date'        => 'required|date|after_or_equal:start_date',
                'locations'       => 'nullable|array',
                'locations.*'     => 'exists:industry,id',
                'clients'         => 'nullable|array',
                'evaluation_data' => 'nullable|string',
            ]);

            $userId = auth()->user()->id;

            // 1. Tạo project
            $project = Project::create([
                'project_name' => $request->project_name,
                'description'  => $request->description,
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
                'userId'       => $userId,
                'clientId'     => $request->clients[0] ?? null, // client đầu tiên
                'status'       => 0,
            ]);

            // 2. Lưu locations → project_industry
            $locations = $request->locations ?? [];
            foreach ($locations as $industryId) {
                ProjectIndustry::create([
                    'project_id'  => $project->project_id,
                    'industry_id' => $industryId,
                ]);
            }

            // 3. Parse evaluation_data JSON
            $evaluationData = [];
            if ($request->filled('evaluation_data')) {
                $evaluationData = json_decode($request->evaluation_data, true) ?? [];
            }

            foreach ($evaluationData as $industryId => $locationData) {
                $parents = $locationData['parents'] ?? [];

                foreach ($parents as $parentId => $parentData) {
                    $parentWeight = (int) ($parentData['criteriaPercent'] ?? 0);

                    // 4. Lưu parent → lấy id vừa insert
                    $projectCriteria = ProjectCriteria::create([
                        'project_id'         => $project->project_id,
                        'industry_id'        => (int) $industryId,
                        'criteria_id'        => (int) $parentId,
                        'weight'             => $parentWeight,
                        'custom_description' => null,
                    ]);

                    // 5. Lưu children với project_criteria_id trỏ về parent vừa tạo
                    $children = $parentData['children'] ?? [];
                    foreach ($children as $childId => $childData) {
                        ProjectCriteriaTarget::create([
                            'project_id'          => $project->project_id,
                            'project_criteria_id' => $projectCriteria->id, // ← FK
                            'industry_id'         => (int) $industryId,
                            'criteria_id'         => (int) $childData['id'],
                            'parent_criteria_id'  => (int) $parentId,
                            'criteria_type_id'    => $childData['criteriaTypeId'] ?? null,
                            'target_value'        => $childData['value'] ?? null,
                            'weight'              => (int) ($childData['criteriaPercent'] ?? 0),
                        ]);
                    }
                }
            }
            return redirect()->route('projects.screen')
                ->with('success', 'Project created successfully');

        } catch (\Exception $e) {
            \Log::error('Error in: ' . __METHOD__, [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
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
            'industries:id,industry_name',
        ])
        ->select(
            'project_id',
            'project_name',
            'clientId',
            'start_date',
            'end_date',
            'status',
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
                'Project ID',
                'Project Name',
                'Client Name',
                'Locations',
                'Status',
                'Start Date',
                'End Date',
            ]);

            $statusMap = [
                0 => 'On Hold',
                1 => 'In Progress',
                2 => 'Pending Review',
                3 => 'Progressing',
                4 => 'Success',
                5 => 'Reject',
            ];

            foreach ($projects as $project) {
                fputcsv($handle, [
                    $project->project_name,
                    $project->project_id,
                    $project->client->client_name ?? '-',
                    $project->industries->pluck('industry_name')->implode(', '),
                    $statusMap[$project->status] ?? 'Unknown',
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

    public function getById(Project $project)
    {
        try {
            $project->load([
                'client',
                'industries:id,industry_name',
                'projectCriteria.criteria:id,criteria_name,criteriaPercent,criteriaTypeId',
                'projectCriteria.targets.criteria:id,criteria_name,criteriaPercent,criteriaTypeId,parentId',
                'projectCriteria.targets.criteriaType:id,name',
            ]);

            $evaluationState = [];

            foreach ($project->projectCriteria as $pc) {
                $industryId = $pc->industry_id;

                if (!isset($evaluationState[$industryId])) {
                    $evaluationState[$industryId] = ['parents' => []];
                }

                $parentId = $pc->criteria_id;
                $evaluationState[$industryId]['parents'][$parentId] = [
                    'id'              => $parentId,
                    'criteriaPercent' => $pc->weight,
                    'info'            => [
                        'id'             => $pc->criteria->id ?? $parentId,
                        'criteria_name'  => $pc->criteria->criteria_name ?? '',
                        'criteriaPercent'=> $pc->criteria->criteriaPercent ?? 0,
                        'criteriaTypeId' => null,
                        'children'       => [],
                    ],
                    'weight'   => $pc->weight,
                    'children' => [],
                ];

                foreach ($pc->targets as $target) {
                    $childId = $target->criteria_id;
                    $evaluationState[$industryId]['parents'][$parentId]['children'][$childId] = [
                        'id'             => $childId,
                        'criteriaTypeId' => $target->criteria_type_id,
                        'parentId'       => $parentId,
                        'criteriaPercent'=> $target->weight,
                        'name'           => $target->criteria->criteria_name ?? '',
                        'value'          => $target->target_value ?? '',
                        'originalPercent' => $target->criteria->criteriaPercent ?? 0,
                        'info' => [
                            'id'             => $childId,
                            'criteria_name'  => $target->criteria->criteria_name ?? '',
                            'criteriaTypeId' => $target->criteria_type_id,
                            'parentId'       => $parentId,
                            'criteriaPercent'=> $target->weight,
                            'originalPercent' => $target->criteria->criteriaPercent ?? 0,
                            'type'           => $target->criteriaType ? [
                                'id'   => $target->criteriaType->id,
                                'name' => $target->criteriaType->name,
                            ] : null,
                        ],
                        'percentage' => $target->weight,
                        'typeId'     => $target->criteria_type_id,
                    ];

                    $evaluationState[$industryId]['parents'][$parentId]['info']['children'][] = [
                        'id'             => $childId,
                        'criteria_name'  => $target->criteria->criteria_name ?? '',
                        'criteriaTypeId' => $target->criteria_type_id,
                        'parentId'       => $parentId,
                        'criteriaPercent'=> $target->weight,
                        'type'           => $target->criteriaType ? [
                            'id'   => $target->criteriaType->id,
                            'name' => $target->criteriaType->name,
                        ] : null,
                    ];
                }
            }

            return view('project.project_update', compact(
                'project',
                'evaluationState'   
            ));

        } catch (\Exception $e) {
            Log::error('get project detail failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
            return redirect()
                ->back()
                ->with('error', 'get project detail failed: ' . $e->getMessage());
        }
    }

    public function detail(Project $project)
    {
        try{
            $project->load([
                'client',
                'industries',
                'projectCriteria.criteria',           
                'projectCriteria.targets.criteria', 
                'projectCriteria.targets.criteriaType',
            ]);

            return view('project.project_detail', compact('project'));
        } catch(\Exception $e){
            Log::error('get project detail failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return redirect()
                ->back()
                ->with('error', 'get project detail failed.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $request->validate([
                'evaluation_data' => 'nullable|string',
            ]);

            $userId = auth()->user()->id;
            $status = 0;

            $project->update([
                'userId'   => $userId,
                'status'   => $status,
            ]);

            // 2. Parse evaluation_data
            $evaluationData = [];
            if ($request->filled('evaluation_data')) {
                $evaluationData = json_decode($request->evaluation_data, true) ?? [];
            }

            if (empty($evaluationData)) {
                return redirect()->route('projects.screen')
                    ->with('success', 'Project updated successfully');
            }

            //Lấy danh sách industry_id có trong request
            $incomingIndustryIds = array_keys($evaluationData);

            //Xóa project_criteria của những industry có trong payload
            $existingCriteriaIds = ProjectCriteria::where('project_id', $project->project_id)
                ->whereIn('industry_id', $incomingIndustryIds)
                ->pluck('id')
                ->toArray();

            if (!empty($existingCriteriaIds)) {
                //Xóa targets trước (FK constraint)
                ProjectCriteriaTarget::whereIn('project_criteria_id', $existingCriteriaIds)
                    ->delete();

                // Xóa parent criteria
                ProjectCriteria::whereIn('id', $existingCriteriaIds)->delete();
            }

            //Insert lại từ evaluationData
            foreach ($evaluationData as $industryId => $locationData) {
                $parents = $locationData['parents'] ?? [];

                foreach ($parents as $parentId => $parentData) {
                    $parentWeight = (int) ($parentData['criteriaPercent'] ?? 0);

                    $projectCriteria = ProjectCriteria::create([
                        'project_id'         => $project->project_id,
                        'industry_id'        => (int) $industryId,
                        'criteria_id'        => (int) $parentId,
                        'weight'             => $parentWeight,
                        'custom_description' => null,
                    ]);

                    $children = $parentData['children'] ?? [];
                    foreach ($children as $childId => $childData) {
                        ProjectCriteriaTarget::create([
                            'project_id'          => $project->project_id,
                            'project_criteria_id' => $projectCriteria->id,
                            'industry_id'         => (int) $industryId,
                            'criteria_id'         => (int) ($childData['id'] ?? $childId),
                            'parent_criteria_id'  => (int) $parentId,
                            'criteria_type_id'    => $childData['criteriaTypeId'] ?? null,
                            'target_value'        => $childData['value'] ?? null,
                            'weight'              => (int) ($childData['criteriaPercent'] ?? 0),
                        ]);
                    }
                }
            }

            return redirect()->route('projects.screen')
                ->with('success', 'Project updated successfully');

        } catch (\Exception $e) {
            Log::error('update project failed', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
            return redirect()
                ->back()
                ->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


    public function delete($project_id)
    {
        try{
            $project = Project::findOrFail($project_id);
            
            $project->delete();

            return redirect()
                ->route('projects.screen')
                ->with('success', 'Project deleted successfully.');
        } catch(\Exception $e){
            Log::error('Delete project failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Delete project failed.');
        }
    }

    public function getEvaluationsById (Project $project)
    {
        try{
            $project->load([
                'client',
                'industries:id,industry_name',
                'projectIndustries',
                'criteria' => function ($q){
                    $q->withPivot(['weight', 'custom_description']);
                    'weight';
                },
            ]);
        return view('evaluations.evaluations', compact('project'));
        } catch(\Exception $e){
            Log::error('project redirect failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'project redirect failed.');
        }
    }

    public function scoreEvaluation(Request $request){
        try{
            $data = $request->all();
            $validated = $request->validate([
                'project_id' => 'required|exists:project,project_id',
                'evaluations' => 'required|array',
                'evaluations.*.total_score' => 'required|numeric|min:0',
                'evaluations.*.criteria' => 'required|array',
                'evaluations.*.criteria.*.score' => 'required|numeric|min:0',
                'evaluations.*.criteria.*.criteria_percentage' => 'required|numeric|min:0',
                'evaluator_notes' => 'nullable|string',
            ]);

            $userId = 2;

            foreach ($request->evaluations as $projectIndustryId => $evaluation) {

                // 1. Create judgment per industry
                $judgment = Judgment::create([
                    'project_industry_id' => $projectIndustryId,
                    'total_score' => $evaluation['total_score'],
                    'evaluator_notes' => $request->evaluator_notes,
                    'user_id' => $userId,
                ]);

                // 2. Create judgment details
                foreach ($evaluation['criteria'] as $criteriaId => $item) {
                    JudgmentDetail::create([
                        'judgment_id' => $judgment->id,
                        'criteriaId' => $criteriaId,
                        'criteria_point' => $item['score'],
                        'criteria_percentage' => $item['criteria_percentage'],
                        'criteria_name' => $item['criteria_name'],
                    ]);
                }
            }

            Project::where('project_id', $request->project_id)
                ->update(['status' => 4]);
            
            return redirect()
                ->route('projects.screen')
                ->with('success', 'Evaluation completed successfully.');
        } catch (\Exception $e){
            Log::error('create score failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'create score failed.');
        }
    }

    public function getReportProjectById(Project $project){
        try{
            if (!$project->projectIndustries()->exists()) {
                return back()->withErrors(
                    'This project has no evaluation data.'
                );
            }
            $project->load([
                'client',
                'projectIndustries.industry',
                'criteria' => function ($q) {
                    $q->withPivot(['weight', 'custom_description'])
                    ->orderBy('id');
                },
                'projectIndustries.judgment.details.criteria',
            ]);
            return view("report.evaluation_report", compact('project'));
        } catch(\Exception $e){   
            Log::error('get report failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'create score failed.');
        }
    }

    public function exportProjectCsv(Project $project)
    {
        try {
            $project->load([
                'client',
                'projectIndustries.industry',
                'projectIndustries.judgment.details'
            ]);

            $fileName = 'evaluation_report_' . $project->project_id . '_' . now()->format('Ymd_His') . '.csv';

            $headers = [
                "Content-Type" => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=\"$fileName\"",
            ];

            $callback = function () use ($project) {
                $handle = fopen('php://output', 'w');

                fwrite($handle, "\xEF\xBB\xBF");

                $criteriaMap = [];
                foreach ($project->projectIndustries as $pi) {
                    foreach (optional($pi->judgment)->details ?? [] as $detail) {
                        $criteriaMap[$detail->criteria_name] = $detail->criteria_percentage;
                    }
                }

                $totalColumns = count($criteriaMap) + 2; // Location + Criteria + Total
                $projectTitleRow = array_fill(0, $totalColumns, '');
                $projectTitleRow[floor($totalColumns/2)] = $project->project_name . " :";
                fputcsv($handle, $projectTitleRow);

                $labelRow = array_fill(0, $totalColumns, '');
                $labelRow[2] = 'Tiêu chí';
                fputcsv($handle, $labelRow);

                $header = ['Location'];
                foreach ($criteriaMap as $name => $weight) {
                    $header[] = "{$name} ({$weight})";
                }
                $header[] = 'Total Score';
                fputcsv($handle, $header);


                foreach ($project->projectIndustries as $pi) {
                    $row = [
                        $pi->industry->industry_name ?? 'Unknown', // Cột Location
                    ];

                    $details = collect(optional($pi->judgment)->details ?? [])->keyBy('criteria_name');

                    foreach ($criteriaMap as $name => $weight) {
                        if ($details->has($name)) {
                            $d = $details[$name];
                            // Export dạng "19/20" như trong hình
                            $row[] = '="' . $d->criteria_point . '/' . $weight . '"';
                        } else {
                            $row[] = '0/' . $weight;
                        }
                    }

                    // Điểm tổng kết thúc dòng
                    $row[] = number_format(optional($pi->judgment)->total_score ?? 0, 2);

                    fputcsv($handle, $row);
                }

                fclose($handle);
            };

            return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('Export project CSV failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return back()->with('error', 'Export project CSV failed.');
        }
    }

}