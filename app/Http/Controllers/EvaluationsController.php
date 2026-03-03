<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Industry;
use App\Models\ProjectIndustry;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Judgment;
use App\Models\JudgmentDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluationsController extends Controller
{
    private function buildScores(Project $project): array
    {
      $project->load([
          'client',
          'industries:id,industry_name',
          'projectCriteria.criteria:id,criteria_name,criteriaPercent',
          'projectCriteria.targets.criteria:id,criteria_name,criteriaTypeId,criteriaPercent',
          'projectCriteria.targets.criteriaType:id,name',
      ]);

      $industries  = $project->industries;
      $scoringData = [];

      foreach ($project->projectCriteria as $pc) {
          $industryId = $pc->industry_id;
          $parentId   = $pc->criteria_id;

          if (!isset($scoringData[$parentId])) {
              $scoringData[$parentId] = [
                    'name'     => $pc->criteria->criteria_name ?? "Criteria #$parentId",
                    'weight'   => [],
                    'children' => [],
                ];
            }

            $scoringData[$parentId]['weight'][$industryId] = $pc->weight;

            foreach ($pc->targets as $target) {
                $childId = $target->criteria_id;
                if (!isset($scoringData[$parentId]['children'][$childId])) {
                    $scoringData[$parentId]['children'][$childId] = [
                        'name'   => $target->criteria->criteria_name ?? "Sub #$childId",
                        'typeId' => $target->criteria_type_id,
                        'weight' => [],
                        'values' => [],
                    ];
                }
                $scoringData[$parentId]['children'][$childId]['weight'][$industryId] = $target->weight;
                $scoringData[$parentId]['children'][$childId]['values'][$industryId] = $target->target_value;
            }
        }

        $scores = [];
        foreach ($industries as $ind) {
            $scores[$ind->id] = ['industry_name' => $ind->industry_name, 'total' => 0, 'parents' => []];
        }

        foreach ($scoringData as $parentId => $parentData) {
            foreach ($industries as $ind) {
                $iid          = $ind->id;
                $parentWeight = $parentData['weight'][$iid] ?? 0;
                $parentScore  = 0;
                $childrenScores = [];

                foreach ($parentData['children'] as $childId => $childData) {
                    $childMaxScore = $parentWeight * (($childData['weight'][$iid] ?? 0) / 100);
                    $allValues     = array_filter($childData['values'], fn($v) => $v !== null && $v !== '');
                    $childScore    = $this->calculateChildScore(
                        $childData['typeId'],
                        $childData['values'][$iid] ?? null,
                        $allValues,
                        $childMaxScore
                    );
                    $childrenScores[$childId] = [
                        'name'     => $childData['name'],
                        'score'    => round($childScore, 2),
                        'maxScore' => round($childMaxScore, 2),
                        'pct'      => $childMaxScore > 0 ? round($childScore / $childMaxScore * 100, 1) : 0,
                        'value'    => $childData['values'][$iid] ?? null,
                        'typeId'   => $childData['typeId'],
                    ];
                    $parentScore += $childScore;
                }

                $scores[$iid]['parents'][$parentId] = [
                    'name'     => $parentData['name'],
                    'score'    => round($parentScore, 2),
                    'maxScore' => $parentWeight,
                    'pct'      => $parentWeight > 0 ? round($parentScore / $parentWeight * 100, 1) : 0,
                    'children' => $childrenScores,
                ];
                $scores[$iid]['total'] += $parentScore;
            }
        }

        foreach ($scores as &$s) { $s['total'] = round($s['total'], 2); }
        unset($s);

        return compact('industries', 'scores', 'scoringData');
    }
    public function getEvaluationsById(Project $project)
    {
        try {
            ['industries' => $industries, 'scores' => $scores, 'scoringData' => $scoringData]
                = $this->buildScores($project);

            if ($industries->isEmpty()) {
                return view('evaluations.evaluations', compact('project'))
                    ->with('warning', 'No locations assigned to this project.');
            }

            $radarLabels   = array_values(array_map(fn($p) => $p['name'], $scoringData));
            $radarMaxes    = array_values(array_map(fn($p) => max(array_values($p['weight']) ?: [0]), $scoringData));

            $palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
            $radarDatasets = [];
            $ci = 0;

            foreach ($scores as $iid => $iScore) {
                $data = [];
                foreach ($scoringData as $pid => $pData) {
                    $data[] = $iScore['parents'][$pid]['score'] ?? 0;
                }
                $color = $palette[$ci % count($palette)];
                $radarDatasets[] = [
                    'label'                => $iScore['industry_name'],
                    'data'                 => $data,
                    'borderColor'          => $color,
                    'backgroundColor'      => $color . '26',
                    'pointBackgroundColor' => $color,
                    'pointRadius'          => 5,
                    'borderWidth'          => 2,
                ];
                $ci++;
            }

            $radarData = compact('radarLabels', 'radarDatasets', 'radarMaxes');

            // =============================================
            // STEP 4: Bar chart data
            // =============================================
            $barDatasets = [];
            $ci = 0;
            foreach ($scores as $iid => $iScore) {
                $color = $palette[$ci % count($palette)];
                $barDatasets[] = [
                    'label'           => $iScore['industry_name'],
                    'data'            => array_values(array_map(fn($p) => $p['score'], $iScore['parents'])),
                    'backgroundColor' => $color . 'cc',
                    'borderColor'     => $color,
                    'borderWidth'     => 1,
                ];
                $ci++;
            }
            $barData = [
                'labels'   => $radarLabels,
                'datasets' => $barDatasets,
            ];

            return view('evaluations.evaluations', compact(
                'project', 'industries', 'scores', 'scoringData', 'radarData', 'barData'
            ));

        } catch (\Exception $e) {
            Log::error('evaluation failed', ['message' => $e->getMessage(), 'line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Evaluation failed: ' . $e->getMessage());
        }
    }

		public function saveJudgment(Request $request, Project $project)
    {
        try {
            ['industries' => $industries, 'scores' => $scores, 'scoringData' => $scoringData]
                = $this->buildScores($project);
            DB::transaction(function () use ($project, $industries, $scores, $scoringData, $request) {

                foreach ($industries as $industry) {
                    $iid = $industry->id;

                  
                    $projectIndustry = ProjectIndustry::where('project_id', $project->project_id)
                        ->where('industry_id', $iid)
                        ->firstOrFail();

                    // Nếu đã có judgment cho project_industry này → xóa cũ, tạo mới
                    Judgment::where('project_industry_id', $projectIndustry->id)->delete();

                    $locationScore = $scores[$iid] ?? null;
                    if (!$locationScore) continue;

                    // INSERT judgment
                    $judgment = Judgment::create([
                        'project_industry_id' => $projectIndustry->id,
                        'total_score'         => $locationScore['total'],
                        'evaluator_notes'     => $request->input('notes'),
                    ]);

                    // INSERT judgment_detail — mỗi child criteria 1 row
                    foreach ($scoringData as $parentId => $parentData) {
                        $parentScore = $locationScore['parents'][$parentId] ?? null;
                        if (!$parentScore) continue;

                        foreach ($parentData['children'] as $childId => $childData) {
                            $childScore = $parentScore['children'][$childId] ?? null;
                            if (!$childScore) continue;

                            JudgmentDetail::create([
                                'judgment_id'          => $judgment->id,
                                'criteriaId'           => $childId,
                                'criteria_name'        => $childScore['name'],
                                'criteria_parent_id'   => $parentId,
                                'criteria_type'        => $childData['typeId'],
                                'criteria_percentage'  => $childData['weight'][$iid] ?? 0,
                                'criteria_point'       => $childScore['score'],
                                'count'                => $childScore['maxScore'],
                            ]);
                        }
                    }
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Results saved successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error('saveJudgment failed', ['message' => $e->getMessage(), 'line' => $e->getLine()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

      public function exportAll(Project $project)
      {
          ['industries' => $industries, 'scores' => $scores, 'scoringData' => $scoringData]
              = $this->buildScores($project);

          // Đường dẫn tuyệt đối đến file PNG đã lưu
          $radarPath = storage_path('app/public/evaluations/radar_' . $project->project_id . '.png');

          return PDF::loadView('evaluations.pdf.export-all', [
              'project'     => $project,
              'scores'      => $scores,
              'scoringData' => $scoringData,
              'radarPath'   => file_exists($radarPath) ? $radarPath : null,
              'industries'  => $industries,
          ])->setPaper('a4', 'landscape')  // landscape nếu nhiều cột
            ->download('Evaluation_' . $project->project_name . '.pdf');
      }

    // =========================================================
    // SCORING ENGINE
    // =========================================================
    private function calculateChildScore(
        ?int   $typeId,
        mixed  $currentValue,
        array  $allValues,
        float  $maxScore
    ): float {
        if ($currentValue === null || $currentValue === '' || $maxScore <= 0) {
            return 0;
        }

        // --- YES / NO ---
        if ($typeId == 4) {
            return strtolower(trim($currentValue)) === 'yes' ? $maxScore : 0;
        }

        // --- 2H4R / 4H9R ---
        if ($typeId == 3) {
            $val = strtoupper(trim($currentValue));
            if ($val === '4H9R') return $maxScore;
            if ($val === '2H4R') return $maxScore * 0.6; // 15/25 = 60%
            return 0;
        }

        // --- CONDITION: Good / Fair / Bad ---
        if ($typeId == 5) {
            $map = ['good' => 1.0, 'fair' => 0.66, 'bad' => 0.33];
            $key = strtolower(trim($currentValue));
            return $maxScore * ($map[$key] ?? 0);
        }

        // --- NUMERIC TYPES ---
        if (in_array($typeId, [1, 2, 6], true) || $typeId === null) {
            // Parse numeric — strip units like "km", "$", ","
            $parseNum = fn($v) => is_numeric($v)
                ? (float) $v
                : (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', $v));

            $currentNum = $parseNum($currentValue);
            if ($currentNum <= 0) return 0;

            $numericAll = array_filter(
                array_map($parseNum, $allValues),
                fn($v) => $v > 0
            );
            if (empty($numericAll)) return 0;

            if ($typeId == 6) {
                // HIGHER is better: score = max × (current / maxVal)
                $best = max($numericAll);
                return $best > 0 ? min($maxScore, $maxScore * ($currentNum / $best)) : 0;
            } else {
                // LOWER is better: score = max × (minVal / current)
                $best = min($numericAll);
                return min($maxScore, $maxScore * ($best / $currentNum));
            }
        }

        return 0;
    }
    public function saveRadar(Request $request, Project $project)
    {
        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $fileName = 'radar_' . $project->project_id . '.png';
        Storage::disk('public')->put('evaluations/' . $fileName, base64_decode($image));

        return response()->json(['ok']);
    }

    public function exportLocation(Project $project, Industry $industry)
    {
        ['scores' => $scores, 'scoringData' => $scoringData]
            = $this->buildScores($project);

        // Lấy data của đúng 1 location
        $locationScore = $scores[$industry->id] ?? null;

        if (!$locationScore) {
            return back()->with('error', 'Location not found in this project.');
        }

        
        return PDF::loadView('evaluations.pdf.single-location', [
            'project'       => $project,
            'industry'      => $industry,
            'locationScore' => $locationScore,   // data của location này
            'scoringData'   => $scoringData,     // để render danh sách criteria
        ])->setPaper('a4', 'portrait')
            ->download('Evaluation_' . $project->project_name . '_' . $industry->industry_name . '.pdf');
    }
}