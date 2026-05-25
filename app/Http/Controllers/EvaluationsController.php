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
          'projectCriteria.targets.criteria.type:id,name',
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
                $resolvedTypeId = $this->resolveChildTypeId($target);
                $resolvedTypeName = $target->criteriaType?->name
                    ?? $target->criteria?->type?->name;

                if (!isset($scoringData[$parentId]['children'][$childId])) {
                    $scoringData[$parentId]['children'][$childId] = [
                        'name'     => $target->criteria->criteria_name ?? "Sub #$childId",
                        'typeId'   => $resolvedTypeId,
                        'typeName' => $resolvedTypeName,
                        'typeIds'  => [],
                        'weight'   => [],
                        'values'   => [],
                    ];
                }

                $childRef = &$scoringData[$parentId]['children'][$childId];
                $childRef['typeIds'][$industryId] = $resolvedTypeId;
                if ($resolvedTypeName) {
                    $childRef['typeName'] = $resolvedTypeName;
                }
                if (!$childRef['typeId'] && $resolvedTypeId) {
                    $childRef['typeId'] = $resolvedTypeId;
                }
                $childRef['weight'][$industryId] = $target->weight;
                $childRef['values'][$industryId] = $target->target_value;
                unset($childRef);
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
                    $cWeightRaw    = $childData['weight'][$iid] ?? 0;
                    $childMaxScore = $parentWeight * ($cWeightRaw / 100);
                    $allValues     = array_filter($childData['values'], fn($v) => $v !== null && $v !== '');
                    $typeId        = $childData['typeIds'][$iid] ?? $childData['typeId'] ?? null;
                    $childScore    = $this->calculateChildScore(
                        $typeId,
                        (int) $childId,
                        $childData['values'][$iid] ?? null,
                        $allValues,
                        $childMaxScore
                    );

                    $isIgnored = ($childScore === null);
                    if ($isIgnored) {
                        $childScore = 0;
                    }

                    $childrenScores[$childId] = [
                        'name'      => $childData['name'],
                        'score'     => round($childScore, 2),
                        'maxScore'  => round($childMaxScore, 2),
                        'pct'       => (!$isIgnored && $childMaxScore > 0) ? round($childScore / $childMaxScore * 100, 1) : 0,
                        'value'     => $childData['values'][$iid] ?? null,
                        'typeId'    => $typeId,
                        'typeName'  => $childData['typeName'] ?? null,
                        'isIgnored' => $isIgnored,
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

						if ($project->status !== 1) {
              $project->update(['status' => 1]);
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
                    'industry_id'           => $iid,
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
          $radarByLocationPaths = [];
          foreach ($industries as $ind) {
              $p = storage_path('app/public/evaluations/radar_' . $project->project_id . '_' . $ind->id . '.png');
              $radarByLocationPaths[$ind->id] = file_exists($p) ? $p : null;
          }

          // Generate score ring PNGs
          $ringPaths = [];
          $palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
          $ci = 0;
          foreach ($industries as $ind) {
              $color = $palette[$ci % count($palette)];
              $ringPaths[$ind->id] = $this->generateScoreRing($scores[$ind->id]['total'], $color, $project->project_id, $ind->id);
              $ci++;
          }

          return PDF::loadView('evaluations.pdf.export-all', [
              'project'     => $project,
              'scores'      => $scores,
              'scoringData' => $scoringData,
              'radarPath'   => file_exists($radarPath) ? $radarPath : null,
              'radarByLocationPaths' => $radarByLocationPaths,
              'ringPaths'   => $ringPaths,
              'industries'  => $industries,
          ])->setPaper('a4', 'portrait')
            ->download('Evaluation_' . $project->project_name . '.pdf');
      }

    /**
     * Type on project target, else master criteria row (criteria.criteriaTypeId).
     */
    private function resolveChildTypeId($target): ?int
    {
        $typeId = $target->criteria_type_id ?? $target->criteria?->criteriaTypeId;

        return $typeId !== null && $typeId !== '' ? (int) $typeId : null;
    }

    // =========================================================
    // SCORING ENGINE
    // =========================================================
    private function calculateChildScore(
        ?int   $typeId,
        int    $criteriaId,
        mixed  $currentValue,
        array  $allValues,
        float  $maxScore
    ): ?float {
        if ($currentValue === null || $currentValue === '' || $maxScore <= 0) {
            return null;
        }

        // --- YES / NO ---
        if ($typeId == 4) {
            return strtolower(trim((string) $currentValue)) === 'yes' ? $maxScore : 0;
        }

        // --- type 3: 4H9R 100%, 2H4R 50%, ZERO 0% ---
        if ($typeId == 3) {
            $val = strtoupper(trim((string) $currentValue));
            if ($val === '4H9R') {
                return $maxScore;
            }
            if ($val === '2H4R') {
                return $maxScore * 0.5;
            }
            if ($val === 'ZERO') {
                return 0.0;
            }

            return 0.0;
        }

        // --- type 6: qualitative scale (sentiment) ---
        if ($typeId == 6) {
            $key = strtolower(trim((string) $currentValue));
            $map = [
                'verygood' => 1.0,
                'good' => 0.7,
                'fair' => 0.5,
                'poor' => 0.3,
                'bad' => 0.0,
            ];

            return $maxScore * ($map[$key] ?? 0);
        }

        // --- type 5: minimum wage (27), CIT (18), or legacy Good/Fair/Bad ---
        if ($typeId == 5) {
            $raw = trim((string) $currentValue);
            $lower = strtolower($raw);

            if ($criteriaId === 27) {
                $n = (int) preg_replace('/\D/', '', $raw);

                return match ($n) {
                    1 => $maxScore * 0.4,
                    2 => $maxScore * 0.6,
                    3 => $maxScore * 0.8,
                    4 => $maxScore * 1.0,
                    default => 0.0,
                };
            }

            if ($criteriaId === 18) {
                $p = (int) preg_replace('/\D/', '', $raw);

                return match ($p) {
                    20 => $maxScore * 0.5,
                    17 => $maxScore * 0.7,
                    15 => $maxScore * 0.8,
                    10 => $maxScore * 1.0,
                    default => 0.0,
                };
            }

            $map = ['good' => 1.0, 'fair' => 0.66, 'bad' => 0.33];

            return $maxScore * ($map[$lower] ?? 0);
        }

        // --- type 7: best value across all locations → score = maxScore × (value / bestValue) ---
        if ($typeId == 7) {
            $parseNum = fn($v) => is_numeric($v)
                ? (float) $v
                : (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', (string) $v));

            $currentNum = $parseNum($currentValue);
            if ($currentNum <= 0) {
                return 0.0;
            }

            $numericAll = array_filter(
                array_map($parseNum, $allValues),
                fn($v) => $v > 0
            );
            if (empty($numericAll)) {
                return 0.0;
            }

            $bestValue = max($numericAll);

            return min($maxScore, $maxScore * ($currentNum / $bestValue));
        }

        // --- NUMERIC types 1, 2 (lower is better) ---
        if (in_array($typeId, [1, 2], true) || $typeId === null) {
            // Parse numeric — strip units like "km", "$", ","
            $parseNum = fn($v) => is_numeric($v)
                ? (float) $v
                : (float) preg_replace('/[^0-9.]/', '', str_replace(',', '', (string) $v));

            $currentNum = $parseNum($currentValue);

            $numericAll = array_map($parseNum, $allValues);
            if (empty($numericAll)) {
                return 0;
            }

            $minValue = min($numericAll);

            // Handle division by zero - if current value is 0, give max score
            if ($currentNum == 0) {
                return (float) $maxScore;
            }

            // Formula: score = (minValue / currentValue) * maxScore
            $score = ($minValue / $currentNum) * $maxScore;

            // Clamp and Round
            return (float) max(0, min($maxScore, round($score, 2)));
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

    public function saveRadarLocation(Request $request, Project $project)
    {
        $industryId = $request->input('industry_id');
        $image = $request->input('image');

        if (!$industryId || !$image) {
            return response()->json(['error' => 'industry_id and image are required'], 422);
        }

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $fileName = 'radar_' . $project->project_id . '_' . $industryId . '.png';
        Storage::disk('public')->put('evaluations/' . $fileName, base64_decode($image));

        return response()->json(['ok']);
    }

    public function exportLocation(Project $project, Industry $industry)
    {
        ['industries' => $industries, 'scores' => $scores, 'scoringData' => $scoringData]
            = $this->buildScores($project);

        $locationScore = $scores[$industry->id] ?? null;
        if (!$locationScore) {
            return back()->with('error', 'Location not found in this project.');
        }

        $locationRadarPath = storage_path('app/public/evaluations/radar_' . $project->project_id . '_' . $industry->id . '.png');

        $palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
        $idx = array_search($industry->id, $industries->pluck('id')->toArray());
        $ringColor = $palette[($idx === false ? 0 : $idx) % count($palette)];
        $ringPath = $this->generateScoreRing($locationScore['total'], $ringColor, $project->project_id, $industry->id);

        return PDF::loadView('evaluations.pdf.single-location', [
            'project'       => $project,
            'industry'      => $industry,
            'locationScore' => $locationScore,
            'scoringData'   => $scoringData,
            'locationRadarPath' => file_exists($locationRadarPath) ? $locationRadarPath : null,
            'ringColor'     => $ringColor,
            'ringPath'      => $ringPath,
        ])->setPaper('a4', 'portrait')
            ->download('Evaluation_' . $project->project_name . '_' . $industry->industry_name . '.pdf');
    }

    private function generateScoreRing($score, $hexColor, $projectId, $industryId)
    {
        $score = max(0, min(100, (float) $score));

        // Supersample 4x for smooth edges, then downsample
        $scale   = 4;
        $outSize = 120;
        $size    = $outSize * $scale; // 480

        $img = imagecreatetruecolor($size, $size);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);

        if (function_exists('imageantialias')) {
            imageantialias($img, true);
        }

        list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
        $mainColor = imagecolorallocate($img, $r, $g, $b);
        $gray      = imagecolorallocate($img, 229, 231, 235); // #e5e7eb

        $cx = $size / 2;
        $cy = $size / 2;
        $thickness = (int) round($size * 0.1);   // 48px at 4x
        $outerR   = (int) round($size * 0.42);   // 201px
        $innerR   = $outerR - $thickness;
        $midR     = ($outerR + $innerR) / 2;
        $capD     = $thickness; // cap diameter = ring thickness

        // 1) Draw full gray ring (donut)
        imagefilledellipse($img, $cx, $cy, $outerR * 2, $outerR * 2, $gray);
        imagefilledellipse($img, $cx, $cy, $innerR * 2, $innerR * 2, $transparent);

        // 2) Draw colored arc
        if ($score > 0) {
            $angle = ($score / 100) * 360; // degrees, clockwise from top

            // Filled arc pie-slice in main color
            imagefilledarc(
                $img, $cx, $cy,
                $outerR * 2, $outerR * 2,
                -90, -90 + $angle,
                $mainColor,
                IMG_ARC_PIE
            );

            // Carve inner hole again so arc becomes a ring segment
            imagefilledellipse($img, $cx, $cy, $innerR * 2, $innerR * 2, $transparent);

            // Round caps at start and end of arc
            $startRad = deg2rad(-90);
            $endRad   = deg2rad(-90 + $angle);

            $sx = (int) round($cx + cos($startRad) * $midR);
            $sy = (int) round($cy + sin($startRad) * $midR);
            $ex = (int) round($cx + cos($endRad)   * $midR);
            $ey = (int) round($cy + sin($endRad)   * $midR);

            imagefilledellipse($img, $sx, $sy, $capD, $capD, $mainColor);
            imagefilledellipse($img, $ex, $ey, $capD, $capD, $mainColor);
        }

        // 3) Downsample to output size for crisp anti-aliased result
        $out = imagecreatetruecolor($outSize, $outSize);
        imagealphablending($out, false);
        imagesavealpha($out, true);
        $outTransparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
        imagefill($out, 0, 0, $outTransparent);
        imagecopyresampled($out, $img, 0, 0, 0, 0, $outSize, $outSize, $size, $size);
        imagedestroy($img);

        $dir = storage_path('app/public/evaluations');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $path = $dir . '/ring_' . $projectId . '_' . $industryId . '.png';
        imagepng($out, $path);
        imagedestroy($out);

        return $path;
    }
}