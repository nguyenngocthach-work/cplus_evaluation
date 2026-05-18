@extends('layouts.app')
@section('title', 'Evaluation Results — ' . $project->project_name)

@push('styles')
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
@endpush

@section('content')
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-32">
  <div class="w-full max-w-[1100px] flex flex-col gap-8">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap gap-2 px-2 text-sm">
      <a href="{{ route('admin.screen') }}" class="text-[#617589] hover:text-primary">Dashboard</a>
      <span class="text-[#617589]">/</span>
      <a href="{{ route('projects.screen') }}" class="text-[#617589] hover:text-primary">Projects</a>
      <span class="text-[#617589]">/</span>
      <a href="{{ route('projects.detail', $project) }}" class="text-[#617589] hover:text-primary">{{ $project->project_name }}</a>
      <span class="text-[#617589]">/</span>
      <span class="text-[#111418] dark:text-white font-medium">Evaluation</span>
    </div>

    {{-- Header --}}
    <div class="flex justify-between items-start px-2">
      <div>
        <h1 class="text-3xl font-black text-[#111418] dark:text-white">Evaluation Results</h1>
        <p class="text-[#617589] dark:text-gray-400 mt-1">{{ $project->project_name }} · {{ $industries->count() }} location(s) compared</p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('projects.evaluations.export', $project) }}"
          class="export-btn opacity-50 pointer-events-none h-9 px-4 flex items-center gap-2 bg-primary text-white rounded-lg text-sm font-semibold hover:opacity-90 transition-all shadow-sm"
          title="Đang lưu radar chart...">
            <span class="material-symbols-outlined text-sm">download</span>
            Export All (PDF)
        </a>

        {{-- BACK --}}
        <a href="{{ route('projects.detail', $project) }}"
          class="h-9 px-4 flex items-center border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-all dark:text-white">
            Back
        </a>
      </div>
    </div>

    {{-- ===== SCORE SUMMARY CARDS ===== --}}
    @php
      $maxTotal = collect($scores)->max('total');
      $palette  = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
      $ci = 0;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(count($scores), 4) }} gap-4">
      @foreach($scores as $iid => $iScore)
        @php
          $color   = $palette[$ci % count($palette)];
          $isWinner = $iScore['total'] == $maxTotal;
          $pct     = min(100, $iScore['total']);
          $stroke  = 2 * pi() * 40;
          $dash    = $stroke * $pct / 100;
          $ci++;
        @endphp
        <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6 flex flex-col items-center gap-3 relative
          {{ $isWinner ? 'ring-2 ring-offset-2 dark:ring-offset-gray-900' : '' }}"
          style="{{ $isWinner ? 'ring-color:'.$color : '' }}">

          @if($isWinner)
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 winner-badge bg-amber-400 text-white text-xs font-bold px-3 py-0.5 rounded-full shadow flex items-center gap-1">
              <span class="material-symbols-outlined text-sm">star</span> Best
            </div>
          @endif

          {{-- Score Ring --}}
          <div class="score-ring w-28 h-28">
            <svg width="112" height="112" viewBox="0 0 112 112">
              <circle cx="56" cy="56" r="40" fill="none" stroke="#e5e7eb" stroke-width="10"/>
              <circle cx="56" cy="56" r="40" fill="none"
                stroke="{{ $color }}" stroke-width="10"
                stroke-dasharray="{{ $dash }} {{ $stroke - $dash }}"
                stroke-linecap="round"/>
            </svg>
            <div class="label">
              <div class="text-2xl font-black dark:text-white" style="color:{{ $color }}">{{ $iScore['total'] }}</div>
              <div class="text-[10px] text-gray-400">/100</div>
            </div>
          </div>

          <div class="text-center">
            <div class="font-bold text-[#111418] dark:text-white text-base">{{ $iScore['industry_name'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5">
              {{ count($iScore['parents']) }} criteria evaluated
            </div>
            <div class="mt-4 w-full">
                <a href="{{ route('projects.evaluations.exportLocation', [$project, $iid]) }}"
                  class="w-full h-8 flex items-center justify-center gap-2 text-xs font-semibold rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all dark:text-white">
                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                    Export {{ $iScore['industry_name'] }}
                </a>
            </div>
          </div>

          {{-- Mini bar per parent --}}
          <div class="w-full space-y-1.5 mt-1">
            @foreach($iScore['parents'] as $pid => $parent)
              <div>
                <div class="flex justify-between text-[10px] text-gray-500 mb-0.5">
                  <span class="truncate max-w-[120px]">{{ $parent['name'] }}</span>
                  <span>{{ $parent['score'] }}/{{ $parent['maxScore'] }}</span>
                </div>
                <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                  <div class="score-bar-fill h-full rounded-full"
                    style="width:{{ $parent['maxScore'] > 0 ? ($parent['score']/$parent['maxScore']*100) : 0 }}%; background:{{ $color }}"></div>
                </div>
              </div>
            @endforeach
          </div>

        </div>
      @endforeach
    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      {{-- Radar Chart --}}
      <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6">
        <h3 class="font-bold text-[#111418] dark:text-white mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">radar</span>
          Spider / Radar Chart
        </h3>
        <div class="relative w-full max-w-[360px] mx-auto aspect-square">
          <canvas id="radarChart"></canvas>
        </div>
      </div>

      {{-- Bar Chart --}}
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

    {{-- ===== RADAR BY LOCATION ===== --}}
    <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm p-6">
      <h3 class="font-bold text-[#111418] dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">radar</span>
        Spider / Radar Chart by Location
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($industries as $ind)
          <div class="rounded-xl border border-[#e5e7eb] dark:border-gray-700 p-4">
            <div class="text-sm font-semibold text-[#111418] dark:text-white mb-3">
              {{ $ind->industry_name }}
            </div>
            <div class="relative w-full max-w-[320px] mx-auto aspect-square">
              <canvas id="radarChartLocation-{{ $ind->id }}"></canvas>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- ===== DETAILED COMPARISON TABLE ===== --}}
    <div class="bg-white dark:bg-[#1a2632] rounded-2xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm overflow-hidden">

      <div class="px-6 py-5 border-b dark:border-gray-700 flex items-center justify-between">
        <h3 class="font-bold text-[#111418] dark:text-white text-lg flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">table_view</span>
          Detailed Score Breakdown
        </h3>
        <span class="text-xs text-gray-400">All values compared across {{ $industries->count() }} locations</span>
      </div>

      <div class="overflow-x-auto">
        <table class="eval-table w-full text-sm border-collapse">
          <thead>
            <tr class="bg-gray-50 dark:bg-gray-800/60">
              <th class="px-4 py-3 text-left font-bold text-[#617589] dark:text-gray-400 uppercase text-xs tracking-wider w-52">Criterion</th>
              <th class="px-3 py-3 text-center font-bold text-[#617589] dark:text-gray-400 uppercase text-xs tracking-wider w-20">Max</th>
              @php $ci2=0; @endphp
              @foreach($industries as $ind)
                @php $color2=$palette[$ci2 % count($palette)]; $ci2++; @endphp
                <th class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider" style="color:{{ $color2 }}">
                  {{ $ind->industry_name }}
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($scoringData as $pid => $pData)
              {{-- Parent row --}}
              <tr class="parent-row border-t dark:border-gray-700">
                <td class="px-4 py-3 flex items-center gap-2 dark:text-white">
                  <span class="material-symbols-outlined text-primary text-base">folder</span>
                  {{ $pData['name'] }}
                </td>
                <td class="px-3 py-3 text-center text-xs text-gray-400">
                  @php $anyW = array_values($pData['weight']); @endphp
                  {{ $anyW[0] ?? 0 }}pts
                </td>
                @foreach($industries as $ind)
                  @php
                    $ps = $scores[$ind->id]['parents'][$pid] ?? null;
                    $pColor = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];
                  @endphp
                  <td class="px-3 py-3 text-center">
                    @if($ps)
                      <div class="inline-flex flex-col items-center">
                        <span class="font-bold text-sm" style="color:{{ $pColor }}">{{ $ps['score'] }}</span>
                        <span class="text-[10px] text-gray-400">/ {{ $ps['maxScore'] }}pts</span>
                        <div class="w-16 h-1 bg-gray-100 dark:bg-gray-700 rounded-full mt-0.5">
                          <div class="h-1 rounded-full" style="width:{{ $ps['pct'] }}%;background:{{ $pColor }}"></div>
                        </div>
                      </div>
                    @else
                      <span class="text-gray-300">—</span>
                    @endif
                  </td>
                @endforeach
              </tr>

              {{-- Child rows --}}
              @foreach($pData['children'] as $cid => $cData)
                <tr class="border-t border-gray-50 dark:border-gray-700/50">
                  <td class="px-4 py-2.5 pl-10 dark:text-gray-300 text-xs flex items-center gap-2">
                    <span class="text-gray-300 dark:text-gray-600">└</span>
                    {{ $cData['name'] }}
                    @if($cData['typeId'])
                      <span class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[9px] px-1.5 py-0.5 rounded ml-1 uppercase">
                        @switch($cData['typeId'])
                          @case(1) cost @break
                          @case(2) dist @break
                          @case(3) 2H/4H @break
                          @case(4) yes/no @break
                          @case(5) min.wage / CIT @break
                          @case(6) scale @break
                          @default type{{ $cData['typeId'] }}
                        @endswitch
                      </span>
                    @endif
                  </td>
                  <td class="px-3 py-2.5 text-center">
                    @php
                      $firstChild = null;
                      foreach($scores as $iScore) {
                          if(isset($iScore['parents'][$pid]['children'][$cid])) {
                              $firstChild = $iScore['parents'][$pid]['children'][$cid];
                              break;
                          }
                      }
                    @endphp
                    <span class="text-[11px] text-gray-400">{{ $firstChild ? $firstChild['maxScore'].'pts' : '—' }}</span>
                  </td>

                  @foreach($industries as $ind)
                    @php
                      $cs = $scores[$ind->id]['parents'][$pid]['children'][$cid] ?? null;
                      $cidxColor = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];

                      // Highlight best value in this row
                      $allChildScores = collect($scores)->map(fn($s) => $s['parents'][$pid]['children'][$cid]['score'] ?? 0);
                      $maxChildScore  = $allChildScores->max();
                    @endphp
                    <td class="px-3 py-2.5 text-center">
                      @if($cs)
                        <div class="flex flex-col items-center gap-0.5">
                          {{-- Input value --}}
                          <span class="text-[11px] text-gray-500 dark:text-gray-400">
                            @if($cs['typeId'] == 4)
                              @if(strtolower($cs['value']) === 'yes')
                                <span class="text-green-600 font-bold">✓ Yes</span>
                              @else
                                <span class="text-red-400">✗ No</span>
                              @endif
                            @elseif($cs['typeId'] == 3)
                              @php $u = strtoupper((string) ($cs['value'] ?? '')); @endphp
                              <span class="font-bold {{ $u === '4H9R' ? 'text-blue-600' : ($u === 'ZERO' ? 'text-gray-500' : 'text-gray-600') }}">
                                {{ $cs['value'] ?: '—' }}
                              </span>
                            @elseif($cs['typeId'] == 6)
                              <span class="text-violet-600 font-medium capitalize">{{ $cs['value'] ?: '—' }}</span>
                            @elseif($cs['typeId'] == 5)
                              <span class="text-amber-800 font-medium">{{ $cs['value'] ?: '—' }}</span>
                            @else
                              {{ $cs['value'] ?: '—' }}
                            @endif
                          </span>
                          {{-- Score --}}
                          <span class="font-bold text-xs {{ $cs['score'] == $maxChildScore && $maxChildScore > 0 ? 'text-green-600' : '' }}"
                            style="{{ $cs['score'] != $maxChildScore || $maxChildScore == 0 ? 'color:'.$cidxColor : '' }}">
                            {{ $cs['score'] }}
                            @if($cs['score'] == $maxChildScore && $maxChildScore > 0)
                              <span class="text-[8px] text-green-500">▲</span>
                            @endif
                          </span>
                        </div>
                      @else
                        <span class="text-gray-200 dark:text-gray-600 text-xs">—</span>
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach

            @endforeach

            {{-- TOTAL ROW --}}
            <tr class="border-t-2 border-primary/30 bg-primary/5 dark:bg-primary/10">
              <td class="px-4 py-4 font-black text-[#111418] dark:text-white uppercase tracking-wide text-sm">
                🏆 Total Score
              </td>
              <td class="px-3 py-4 text-center text-xs font-bold text-gray-400">100 pts</td>
              @foreach($industries as $ind)
                @php
                  $total     = $scores[$ind->id]['total'];
                  $isWin     = $total == $maxTotal;
                  $totColor  = $palette[array_search($ind->id, $industries->pluck('id')->toArray()) % count($palette)];
                @endphp
                <td class="px-3 py-4 text-center">
                  <div class="inline-flex flex-col items-center">
                    <span class="text-xl font-black {{ $isWin ? 'text-amber-500' : '' }}"
                      style="{{ !$isWin ? 'color:'.$totColor : '' }}">
                      {{ $total }}
                      @if($isWin) ★ @endif
                    </span>
                    <span class="text-[10px] text-gray-400">/ 100</span>
                  </div>
                </td>
              @endforeach
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
const radarData = @json($radarData);
const industries = @json($industries->map(fn($i) => ['id' => $i->id, 'industry_name' => $i->industry_name])->values());
let radarSaved = false;

const radarChart = new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels:   radarData.radarLabels,
        datasets: radarData.radarDatasets,
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 1,
        animation: {
            onComplete: () => {
                if (radarSaved) return; // tránh gọi nhiều lần
                radarSaved = true;

                const base64 = radarChart.toBase64Image();
                fetch('/projects/{{ $project->project_id }}/save-radar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

// ==================== RADAR BY LOCATION ====================
const radarDatasetByIndustryId = {};
(radarData.radarDatasets || []).forEach(ds => {
    if (typeof ds.industry_id !== 'undefined') {
        radarDatasetByIndustryId[String(ds.industry_id)] = ds;
    }
});

industries.forEach(ind => {
    const el = document.getElementById(`radarChartLocation-${ind.id}`);
    if (!el) return;

    const ds = radarDatasetByIndustryId[String(ind.id)];
    if (!ds) return;

    let locationRadarSaved = false;
    const locationRadarChart = new Chart(el, {
        type: 'radar',
        data: {
            labels: radarData.radarLabels,
            datasets: [{
                ...ds,
                data: Array.isArray(ds.data) ? [...ds.data] : []
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            animation: {
                onComplete: () => {
                    if (locationRadarSaved) return;
                    locationRadarSaved = true;
                    const base64 = locationRadarChart.toBase64Image();
                    fetch('/projects/{{ $project->project_id }}/save-radar-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            industry_id: ind.id,
                            image: base64
                        })
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
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw} pts` } }
            },
        }
    });
});

// ==================== BAR ====================
const barData = @json($barData);

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
@endsection