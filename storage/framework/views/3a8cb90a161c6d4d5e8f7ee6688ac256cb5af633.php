
<?php $__env->startSection('title', 'Evaluation Results — ' . $project->project_name); ?>

<?php $__env->startPush('styles'); ?>
<style>
body { font-family: 'Manrope', sans-serif; }
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

/* Score ring */
.score-ring { position: relative; display: inline-flex; align-items: center; justify-content: center; }
.score-ring svg { transform: rotate(-90deg); }
.score-ring .label { position: absolute; text-align: center; }

/* Table zebra */
.eval-table tr:nth-child(even) { background: #f8fafc; }
.dark .eval-table tr:nth-child(even) { background: #1e2d3d; }
.eval-table .parent-row { background: #eff6ff !important; font-weight: 700; }
.dark .eval-table .parent-row { background: #1e2d3d !important; }

/* Winner badge */
.winner-badge { animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{ box-shadow: 0 0 0 0 rgba(59,130,246,.4); } 70%{ box-shadow: 0 0 0 6px rgba(59,130,246,0); } }

/* Score bar */
.score-bar-fill { transition: width 1s ease-in-out; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-32">
  <div class="w-full max-w-[1100px] flex flex-col gap-8">

    
    <div class="flex flex-wrap gap-2 px-2 text-sm">
      <a href="<?php echo e(route('admin.screen')); ?>" class="text-[#617589] hover:text-primary">Dashboard</a>
      <span class="text-[#617589]">/</span>
      <a href="<?php echo e(route('projects.screen')); ?>" class="text-[#617589] hover:text-primary">Projects</a>
      <span class="text-[#617589]">/</span>
      <a href="<?php echo e(route('projects.detail', $project)); ?>" class="text-[#617589] hover:text-primary"><?php echo e($project->project_name); ?></a>
      <span class="text-[#617589]">/</span>
      <span class="text-[#111418] dark:text-white font-medium">Evaluation</span>
    </div>

    
    <div class="flex justify-between items-start px-2">
      <div>
        <h1 class="text-3xl font-black text-[#111418] dark:text-white">Evaluation Results</h1>
        <p class="text-[#617589] dark:text-gray-400 mt-1"><?php echo e($project->project_name); ?> · <?php echo e($industries->count()); ?> location(s) compared</p>
      </div>
      <div class="flex gap-2">
        <a href="<?php echo e(route('projects.evaluations.export', $project)); ?>"
          class="export-btn opacity-50 pointer-events-none h-9 px-4 flex items-center gap-2 bg-primary text-white rounded-lg text-sm font-semibold hover:opacity-90 transition-all shadow-sm"
          title="Đang lưu radar chart...">
            <span class="material-symbols-outlined text-sm">download</span>
            Export All (PDF)
        </a>

        
        <a href="<?php echo e(route('projects.detail', $project)); ?>"
          class="h-9 px-4 flex items-center border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-all dark:text-white">
            Back
        </a>
      </div>
    </div>

    
    <?php
      $maxTotal = collect($scores)->max('total');
      $palette  = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
      $ci = 0;
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?php echo e(min(count($scores), 4)); ?> gap-4">
      <?php $__currentLoopData = $scores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iid => $iScore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $color   = $palette[$ci % count($palette)];
          $isWinner = $iScore['total'] == $maxTotal;
          $pct     = min(100, $iScore['total']);
          $stroke  = 2 * pi() * 40;
          $dash    = $stroke * $pct / 100;
          $ci++;
        ?>
        <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6 flex flex-col items-center gap-3 relative
          <?php echo e($isWinner ? 'ring-2 ring-offset-2 dark:ring-offset-gray-900' : ''); ?>"
          style="<?php echo e($isWinner ? 'ring-color:'.$color : ''); ?>">

          <?php if($isWinner): ?>
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 winner-badge bg-amber-400 text-white text-xs font-bold px-3 py-0.5 rounded-full shadow flex items-center gap-1">
              <span class="material-symbols-outlined text-sm">star</span> Best
            </div>
          <?php endif; ?>

          
          <div class="score-ring w-28 h-28">
            <svg width="112" height="112" viewBox="0 0 112 112">
              <circle cx="56" cy="56" r="40" fill="none" stroke="#e5e7eb" stroke-width="10"/>
              <circle cx="56" cy="56" r="40" fill="none"
                stroke="<?php echo e($color); ?>" stroke-width="10"
                stroke-dasharray="<?php echo e($dash); ?> <?php echo e($stroke - $dash); ?>"
                stroke-linecap="round"/>
            </svg>
            <div class="label">
              <div class="text-2xl font-black dark:text-white" style="color:<?php echo e($color); ?>"><?php echo e($iScore['total']); ?></div>
              <div class="text-[10px] text-gray-400">/100</div>
            </div>
          </div>

          <div class="text-center">
            <div class="font-bold text-[#111418] dark:text-white text-base"><?php echo e($iScore['industry_name']); ?></div>
            <div class="text-xs text-gray-400 mt-0.5">
              <?php echo e(count($iScore['parents'])); ?> criteria evaluated
            </div>
            <div class="mt-4 w-full">
                <a href="<?php echo e(route('projects.evaluations.exportLocation', [$project, $iid])); ?>"
                  class="w-full h-8 flex items-center justify-center gap-2 text-xs font-semibold rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all dark:text-white">
                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                    Export <?php echo e($iScore['industry_name']); ?>

                </a>
            </div>
          </div>

          
          <div class="w-full space-y-1.5 mt-1">
            <?php $__currentLoopData = $iScore['parents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pid => $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div>
                <div class="flex justify-between text-[10px] text-gray-500 mb-0.5">
                  <span class="truncate max-w-[120px]"><?php echo e($parent['name']); ?></span>
                  <span><?php echo e($parent['score']); ?>/<?php echo e($parent['maxScore']); ?></span>
                </div>
                <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                  <div class="score-bar-fill h-full rounded-full"
                    style="width:<?php echo e($parent['maxScore'] > 0 ? ($parent['score']/$parent['maxScore']*100) : 0); ?>%; background:<?php echo e($color); ?>"></div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      
      <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6">
        <h3 class="font-bold text-[#111418] dark:text-white mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">radar</span>
          Spider / Radar Chart
        </h3>
        <div class="relative h-72">
          <canvas id="radarChart"></canvas>
        </div>
      </div>

      
      <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6">
        <h3 class="font-bold text-[#111418] dark:text-white mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">bar_chart</span>
          Score by Criterion
        </h3>
        <div class="relative h-72">
          <canvas id="barChart"></canvas>
        </div>
      </div>

    </div>

    
    <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm overflow-hidden">

      <div class="px-6 py-5 border-b dark:border-gray-700 flex items-center justify-between">
        <h3 class="font-bold text-[#111418] dark:text-white text-lg flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">table_view</span>
          Detailed Score Breakdown
        </h3>
        <span class="text-xs text-gray-400">All values compared across <?php echo e($industries->count()); ?> locations</span>
      </div>

      <div class="overflow-x-auto">
        <table class="eval-table w-full text-sm border-collapse">
          <thead>
            <tr class="bg-gray-50 dark:bg-gray-800/60">
              <th class="px-4 py-3 text-left font-bold text-[#617589] dark:text-gray-400 uppercase text-xs tracking-wider w-52">Criterion</th>
              <th class="px-3 py-3 text-center font-bold text-[#617589] dark:text-gray-400 uppercase text-xs tracking-wider w-20">Max</th>
              <?php $ci2=0; ?>
              <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $color2=$palette[$ci2 % count($palette)]; $ci2++; ?>
                <th class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider" style="color:<?php echo e($color2); ?>">
                  <?php echo e($ind->industry_name); ?>

                </th>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $scoringData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pid => $pData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              
              <tr class="parent-row border-t dark:border-gray-700">
                <td class="px-4 py-3 flex items-center gap-2 dark:text-white">
                  <span class="material-symbols-outlined text-primary text-base">folder</span>
                  <?php echo e($pData['name']); ?>

                </td>
                <td class="px-3 py-3 text-center text-xs text-gray-400">
                  <?php $anyW = array_values($pData['weight']); ?>
                  <?php echo e($anyW[0] ?? 0); ?>pts
                </td>
                <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                    $ps = $scores[$ind->id]['parents'][$pid] ?? null;
                    $pColor = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];
                  ?>
                  <td class="px-3 py-3 text-center">
                    <?php if($ps): ?>
                      <div class="inline-flex flex-col items-center">
                        <span class="font-bold text-sm" style="color:<?php echo e($pColor); ?>"><?php echo e($ps['score']); ?></span>
                        <span class="text-[10px] text-gray-400">/ <?php echo e($ps['maxScore']); ?>pts</span>
                        <div class="w-16 h-1 bg-gray-100 dark:bg-gray-700 rounded-full mt-0.5">
                          <div class="h-1 rounded-full" style="width:<?php echo e($ps['pct']); ?>%;background:<?php echo e($pColor); ?>"></div>
                        </div>
                      </div>
                    <?php else: ?>
                      <span class="text-gray-300">—</span>
                    <?php endif; ?>
                  </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>

              
              <?php $__currentLoopData = $pData['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cid => $cData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-t border-gray-50 dark:border-gray-700/50">
                  <td class="px-4 py-2.5 pl-10 dark:text-gray-300 text-xs flex items-center gap-2">
                    <span class="text-gray-300 dark:text-gray-600">└</span>
                    <?php echo e($cData['name']); ?>

                    <?php if($cData['typeId']): ?>
                      <span class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[9px] px-1.5 py-0.5 rounded ml-1 uppercase">
                        <?php switch($cData['typeId']):
                          case (1): ?> cost <?php break; ?>
                          <?php case (2): ?> dist <?php break; ?>
                          <?php case (3): ?> 2H/4H <?php break; ?>
                          <?php case (4): ?> yes/no <?php break; ?>
                          <?php case (5): ?> cond <?php break; ?>
                          <?php case (6): ?> year <?php break; ?>
                          <?php default: ?> type<?php echo e($cData['typeId']); ?>

                        <?php endswitch; ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="px-3 py-2.5 text-center">
                    <?php
                      $firstChild = null;
                      foreach($scores as $iScore) {
                          if(isset($iScore['parents'][$pid]['children'][$cid])) {
                              $firstChild = $iScore['parents'][$pid]['children'][$cid];
                              break;
                          }
                      }
                    ?>
                    <span class="text-[11px] text-gray-400"><?php echo e($firstChild ? $firstChild['maxScore'].'pts' : '—'); ?></span>
                  </td>

                  <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                      $cs = $scores[$ind->id]['parents'][$pid]['children'][$cid] ?? null;
                      $cidxColor = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];

                      // Highlight best value in this row
                      $allChildScores = collect($scores)->map(fn($s) => $s['parents'][$pid]['children'][$cid]['score'] ?? 0);
                      $maxChildScore  = $allChildScores->max();
                    ?>
                    <td class="px-3 py-2.5 text-center">
                      <?php if($cs): ?>
                        <div class="flex flex-col items-center gap-0.5">
                          
                          <span class="text-[11px] text-gray-500 dark:text-gray-400">
                            <?php if($cs['typeId'] == 4): ?>
                              <?php if(strtolower($cs['value']) === 'yes'): ?>
                                <span class="text-green-600 font-bold">✓ Yes</span>
                              <?php else: ?>
                                <span class="text-red-400">✗ No</span>
                              <?php endif; ?>
                            <?php elseif($cs['typeId'] == 3): ?>
                              <span class="font-bold <?php echo e(strtoupper($cs['value']) === '4H9R' ? 'text-blue-600' : 'text-gray-500'); ?>">
                                <?php echo e($cs['value'] ?: '—'); ?>

                              </span>
                            <?php else: ?>
                              <?php echo e($cs['value'] ?: '—'); ?>

                            <?php endif; ?>
                          </span>
                          
                          <span class="font-bold text-xs <?php echo e($cs['score'] == $maxChildScore && $maxChildScore > 0 ? 'text-green-600' : ''); ?>"
                            style="<?php echo e($cs['score'] != $maxChildScore || $maxChildScore == 0 ? 'color:'.$cidxColor : ''); ?>">
                            <?php echo e($cs['score']); ?>

                            <?php if($cs['score'] == $maxChildScore && $maxChildScore > 0): ?>
                              <span class="text-[8px] text-green-500">▲</span>
                            <?php endif; ?>
                          </span>
                        </div>
                      <?php else: ?>
                        <span class="text-gray-200 dark:text-gray-600 text-xs">—</span>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <tr class="border-t-2 border-primary/30 bg-primary/5 dark:bg-primary/10">
              <td class="px-4 py-4 font-black text-[#111418] dark:text-white uppercase tracking-wide text-sm">
                🏆 Total Score
              </td>
              <td class="px-3 py-4 text-center text-xs font-bold text-gray-400">100 pts</td>
              <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                  $total     = $scores[$ind->id]['total'];
                  $isWin     = $total == $maxTotal;
                  $totColor  = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];
                ?>
                <td class="px-3 py-4 text-center">
                  <div class="inline-flex flex-col items-center">
                    <span class="text-xl font-black <?php echo e($isWin ? 'text-amber-500' : ''); ?>"
                      style="<?php echo e(!$isWin ? 'color:'.$totColor : ''); ?>">
                      <?php echo e($total); ?>

                      <?php if($isWin): ?> ★ <?php endif; ?>
                    </span>
                    <span class="text-[10px] text-gray-400">/ 100</span>
                  </div>
                </td>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="h-8"></div>
  </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
const isDark     = document.documentElement.classList.contains('dark');
const gridColor  = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
const labelColor = isDark ? '#94a3b8' : '#617589';

// ==================== RADAR ====================
const radarData = <?php echo json_encode($radarData, 15, 512) ?>;
let radarSaved = false;

const radarChart = new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels:   radarData.radarLabels,
        datasets: radarData.radarDatasets,
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            onComplete: () => {
                if (radarSaved) return; // tránh gọi nhiều lần
                radarSaved = true;

                const base64 = radarChart.toBase64Image();
                fetch('/projects/<?php echo e($project->project_id); ?>/save-radar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ image: base64 })
                }).then(() => {
                    // Mở khóa nút export sau khi đã lưu xong
                    document.querySelectorAll('.export-btn').forEach(btn => {
                        btn.classList.remove('opacity-50', 'pointer-events-none');
                        btn.removeAttribute('title');
                    });
                });
            }
        },
        scales: {
            r: {
                min: 0,
                suggestedMax: Math.max(...(radarData.radarMaxes || [100])),
                ticks: { color: labelColor, backdropColor: 'transparent', font: { size: 10 } },
                grid:        { color: gridColor },
                angleLines:  { color: gridColor },
                pointLabels: { color: labelColor, font: { size: 11, weight: '600' } },
            }
        },
        plugins: {
            legend: { position: 'bottom', labels: { color: labelColor, boxWidth: 12, padding: 16 } },
            tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} pts` } }
        },
    }
});

// ==================== BAR ====================
const barData = <?php echo json_encode($barData, 15, 512) ?>;

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: barData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { ticks: { color: labelColor, font: { size: 10 } }, grid: { color: gridColor } },
            y: { beginAtZero: true, ticks: { color: labelColor }, grid: { color: gridColor } }
        },
        plugins: {
            legend: { position: 'bottom', labels: { color: labelColor, boxWidth: 12, padding: 16 } },
            tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} pts` } }
        },
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/evaluations/evaluations.blade.php ENDPATH**/ ?>