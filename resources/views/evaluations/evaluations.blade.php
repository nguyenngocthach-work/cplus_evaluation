@extends('layouts.app')
@section('title','Project Details & Evaluation')
@push('styles')
<style>
/* Custom styles for range slider to match primary color */
input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: #137fec;
  cursor: pointer;
  margin-top: -6px;
}

input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 4px;
  cursor: pointer;
  background: #e5e7eb;
  border-radius: 2px;
}

.dark input[type=range]::-webkit-slider-runnable-track {
  background: #374151;
}

/* Custom scrollbar for cleanliness */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 20px;
}

.location-tab.active {
  border-bottom: 3px solid #137fec;
  color: #137fec;
}
</style>
@endpush
@section('content')
<form action="{{ route('projects.evaluationsScore') }}" method="POST" id="evaluation-form">
  @csrf
  <input type="hidden" name="project_id" value="{{ old('project_id', $project->project_id) }}">
  <main class="flex-1 w-full max-w-[1440px] mx-auto p-4 md:p-8 lg:p-10 gap-6 flex flex-col">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 items-center text-sm">
      <a class="text-[#617589] hover:text-primary transition-colors font-medium" href="{{ route('admin.screen') }}">Home</a>
      <span class="material-symbols-outlined text-[#617589] text-[16px]">chevron_right</span>
      <a class="text-[#617589] hover:text-primary transition-colors font-medium" href="{{ route('projects.screen') }}">Projects</a>
      <span class="material-symbols-outlined text-[#617589] text-[16px]">chevron_right</span>
      <span class="text-[#111418] dark:text-white font-semibold">{{ $project->project_name }}</span>
    </div>
    @php
    $statusMap = [
    0 => ['label' => 'On Hold', 'color' => 'bg-yellow-100 text-gray-800'],
    1 => ['label' => 'In Progress', 'color' => 'bg-blue-100 text-blue-800'],
    2 => ['label' => 'Pending Review', 'color' => 'bg-yellow-100 text-yellow-800'],
    3 => ['label' => 'Progressing', 'color' => 'bg-purple-100 text-blue-800'],
    4 => ['label' => 'Success', 'color' => 'bg-green-100 text-green-800'],
    5 => ['label' => 'Rejected', 'color' => 'bg-red-100 text-red-800'],
    ];
    @endphp
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
      <div class="flex flex-col gap-2">
        <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">{{ $project->project_name }}</h1>
        <div class="flex flex-wrap items-center gap-3 text-[#617589] text-sm">
          <span
            class="px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider
                  {{ $statusMap[$project->status]['color'] }}">
            {{ $statusMap[$project->status]['label'] }}
          </span>
          <span>•</span>
          <span>Project ID: {{ old('project_id', $project->project_id) }}</span>
          <span>•</span>
          <span>Created on {{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('M d, Y')) }}</span>
        </div>
      </div>
      <div class="flex gap-3">
        <!-- <button
          class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-[#2d3748] border border-[#dbe0e6] dark:border-[#4a5568] text-[#111418] dark:text-white text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-[#374151] transition-colors gap-2">
          <span class="material-symbols-outlined text-[18px]">edit</span>
          <span class="truncate">Edit Project</span>
        </button> -->
        <a href="{{ route('projects.reportById', $project) }}"
          class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary/90 transition-colors gap-2">
          <span class="material-symbols-outlined text-[18px]">download</span>
          <span class="truncate">Export Report</span>
        </a>
      </div>
    </div>
    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 px-4 py-3 text-sm">
        {{ $errors->first() }}
      </div>
      @endif
    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      <!-- LEFT COLUMN: Context & Info (Span 4) -->
      <div class="lg:col-span-4 flex flex-col gap-6">
        <!-- Project Details Card -->
        <div
          class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#2d3748] overflow-hidden">
          <div
            class="px-6 py-4 border-b border-[#e5e7eb] dark:border-[#2d3748] flex justify-between items-center bg-gray-50 dark:bg-[#1f2933]">
            <h3 class="font-bold text-lg">Project Details</h3>
            <a href="{{ route('projects.detail', $project) }}">
              <span class="material-symbols-outlined text-[#617589]">info</span>
            </a>
          </div>
          <div class="p-6">
            <div class="grid grid-cols-1 gap-y-4">
              <div class="flex flex-col gap-1 pb-4 border-b border-[#f0f2f4] dark:border-[#2d3748]">
                <p class="text-[#617589] text-xs uppercase font-semibold tracking-wider">Client</p>
                <div class="flex items-center gap-2">
                  <div
                    class="size-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                    A</div>
                  <p class="font-medium">{{ old('company_name', $project->client->company_name) }}</p>
                </div>
              </div>
              <div class=" flex flex-col gap-1 pb-4 border-b border-[#f0f2f4] dark:border-[#2d3748]">
                <p class="text-[#617589] text-xs uppercase font-semibold tracking-wider">Project Manager</p>
                <div class="flex items-center gap-2">
                  <div class="size-6 bg-cover bg-center rounded-full" data-alt="Small avatar of project manager"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDWt0coioBlu6d2Q2sLG2XYVzW-r_y2F5YpCFIs9Fj11NB2YHzPJfW3wANnD4o3cEGA3dhFt6Ghgv4jEBS3-tuJNNL_ZvvAlgox2uM5eRFkbOEUMqjaa18R3BnxzVJ6-FFISaV6ZgjZKu70ssXSOXbpyAKj-cRs9J6ZUh8x7bLa9gA1JJE5aXFXMwUscEONU0E7xGIDZFpaOgDKSv_qiCO8RCF8I_Vp3Yqci-RS3K4G9alUkAO1NWLPjLxHRMCjy6zNa6d76cb0jdgu')">
                  </div>
                  <p class="font-medium">{{ old('client_name', $project->client->client_name) }}</p>
                </div>
              </div>
              <div class="flex flex-col gap-1 pb-4 border-b border-[#f0f2f4] dark:border-[#2d3748]">
                <p class="text-[#617589] text-xs uppercase font-semibold tracking-wider">Due Date</p>
                <p class="font-medium">
                  {{ old('end_date', \Carbon\Carbon::parse($project->end_date)->format('M d, Y')) }}
                </p>
              </div>
              <div class="flex flex-col gap-1">
                <p class="text-[#617589] text-xs uppercase font-semibold tracking-wider">Description</p>
                <p class="text-sm text-[#617589] leading-relaxed">{{ old('description', $project->description) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- RIGHT COLUMN: Evaluation Interface (Span 8) -->
      <div class="lg:col-span-8 flex flex-col h-full">
        <!-- Location Tabs -->
        <div class="flex border-b border-[#dbe0e6] dark:border-[#4a5568] gap-8 mb-6 overflow-x-auto hide-scrollbar">
          @foreach($project->projectIndustries as $pi)
          <button type="button"
            class="location-tab {{ $pi === 0 ? 'active' : '' }} flex items-center gap-2 border-b-[3px] border-b-primary text-primary pb-3 px-1 whitespace-nowrap outline-none group"
            data-project-industry-id="{{ $pi->id }}"
            data-industry-id="{{ $pi->industry->id }}">
            <span class="material-symbols-outlined text-[20px]">storefront</span>
            <span class="text-sm font-bold tracking-[0.015em]">{{ $pi->industry->industry_name }}</span>
          </button>
          @endforeach
        </div>
        <!-- Evaluation Workspace -->
        <div
          class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#2d3748] flex flex-col flex-1">
          <!-- Scoring Header -->
          <div
            class="px-6 py-5 border-b border-[#e5e7eb] dark:border-[#2d3748] flex flex-wrap justify-between items-center gap-4">
            <div>
              <h2 class="text-xl font-bold">Evaluation: Downtown Store</h2>
              <p class="text-sm text-[#617589]">Last updated just now by You {{ old('userId', $project->userId) }}</p>
            </div>
            <div
              class="flex items-center gap-4 bg-primary/5 dark:bg-primary/10 px-4 py-2 rounded-lg border border-primary/10">
              <div class="text-right">
                <p class="text-xs font-bold text-[#617589] uppercase tracking-wider">Total Score</p>
                <p class="text-2xl font-black text-primary leading-none"><span id="total-score-display">0.0</span> 
                <span class="text-sm text-[#617589] font-medium" id="total-score-max">/ 0.0</span></p>
              </div>
              <div class="h-10 w-px bg-[#dbe0e6] dark:bg-[#4a5568]"></div>
              <div
                class="size-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined">thumb_up</span>
              </div>
            </div>
          </div>
          <!-- Split View: Inputs & Chart -->
          <div
            class="flex flex-col xl:flex-row divide-y xl:divide-y-0 xl:divide-x divide-[#e5e7eb] dark:divide-[#2d3748]">
            <!-- Left: Scoring Inputs -->
            <div class="p-6 xl:w-1/2 flex flex-col gap-6">
              <h4 class="font-bold text-sm uppercase text-[#617589] tracking-wider mb-2">Scoring Criteria</h4>
              @foreach($project->criteria as $criterion)
              <!-- Criterion 1 -->
              <div class="group">
                <div class="flex justify-between items-end mb-2">
                  <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#617589] text-[18px]">directions_walk</span>
                    {{ old('criteria_name', $criterion->criteria_name)}}
                  </label>
                  <span class="score-value font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">{{ $criterion->pivot->weight }}</span>
                </div>
                <!-- <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                  max="10" min="1" step="0.5" type="range" value="8" /> -->
                <input
                  class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 criterion-slider"
                  max="{{ $criterion->pivot->weight }}" min="0" step="0.5" type="range" value="5.0"
                  data-name="{{ $criterion->criteria_name }}"
                  data-criteria-id="{{ $criterion->id }}"
                  data-weight="{{ $criterion->pivot->weight }}" />
                <div class="flex justify-between text-xs text-[#617589] mt-1">
                  <span>Low</span>
                  <span>High</span>
                </div>
              </div>
              @endforeach
            </div>
            <!-- Right: Radar Chart Visualization -->
            <div
              class="p-6 xl:w-1/2 flex flex-col items-center justify-center bg-gray-50/50 dark:bg-[#1a242d]/50 relative">
              <div class="absolute top-4 right-4 flex gap-2">
                <div
                  class="flex items-center gap-1.5 bg-white dark:bg-[#2d3748] px-2 py-1 rounded shadow-sm border border-gray-100 dark:border-gray-600">
                  <span class="size-2 rounded-full bg-primary"></span>
                  <span class="text-xs font-medium">Current</span>
                </div>
                <div
                  class="flex items-center gap-1.5 bg-white dark:bg-[#2d3748] px-2 py-1 rounded shadow-sm border border-gray-100 dark:border-gray-600 opacity-60">
                  <span class="size-2 rounded-full bg-gray-400"></span>
                  <span class="text-xs font-medium">Avg</span>
                </div>
              </div>
              <!-- SVG Radar Chart -->
              <div class="w-full max-w-[320px] aspect-square relative"
                data-alt="Radar chart visualization showing scores across 5 axes">
                <svg class="w-full h-full drop-shadow-lg" viewBox="0 0 200 200">
                  <!-- Grid -->
                  <g id="radar-grid" class="stroke-[#dbe0e6] dark:stroke-[#4a5568]" fill="none" stroke-width="1"></g>

                  <!-- Axes -->
                  <g id="radar-axes" class="stroke-[#dbe0e6] dark:stroke-[#4a5568]" stroke-dasharray="2 2"
                    stroke-width="1"></g>

                  <!-- Data polygon -->
                  <g id="radar-polygons" fill="#137fec" fill-opacity="0.25" stroke="#137fec" stroke-width="2.5">
                  </g>

                  <!-- Data points -->
                  <g id="radar-dots"></g>
                </svg>

                <!-- Labels (HTML) -->
                <div id="radar-labels" class="absolute inset-0 pointer-events-none"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer: Comments & Actions -->
        <div class="p-6 border-t border-[#e5e7eb] dark:border-[#2d3748] bg-gray-50/50 dark:bg-[#1a242d]/30 mt-auto">
          <div class="flex flex-col gap-4">
            <div>
              <label class="font-bold text-sm text-[#111418] dark:text-white mb-2 block">
                Evaluator Notes
              </label>
              <textarea name="evaluator_notes"
                class="w-full rounded-lg border-none bg-white dark:bg-[#1a242d] p-3 text-sm focus:ring-2 focus:ring-primary/50 outline-none resize-none shadow-sm dark:text-white"
                placeholder="Enter specific observations about this location, e.g. 'Entrance is obscured by scaffolding...'"
                rows="3"></textarea>
            </div>
            <div class="flex justify-end items-center gap-4 pt-2">
              <span class="text-xs text-[#617589] italic">Changes saved automatically</span>
              <button
                class="bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                Complete Evaluation
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
</form>
<script>
window.projectIndustryMap = @json(
  $project->projectIndustries->pluck('id', 'industry_id')
);
let evaluationState = {};

document.querySelectorAll('.location-tab').forEach((btn, index) => {
    btn.classList.remove('active', 'border-b-primary', 'text-primary');
    btn.classList.add('text-[#617589]', 'border-transparent');

    if (index === 0) {
        btn.classList.add('active', 'border-b-primary', 'text-primary');
        btn.classList.remove('text-[#617589]', 'border-transparent');
    }
});

const radarColors = ['#137fec', '#f97316', '#22c55e', '#a855f7'];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Lấy danh sách Industry IDs từ Tabs
    const tabs = document.querySelectorAll('.location-tab');
    const projectIndustryIds = [...tabs].map(btn => String(btn.dataset.projectIndustryId));
    const sliders = document.querySelectorAll('.criterion-slider');
    const numCriteria = sliders.length;

    let activeProjectIndustryId = projectIndustryIds[0];

    function getIndustryColor(id) {
        const index = projectIndustryIds.indexOf(id);
        return radarColors[index % radarColors.length];
    }


    projectIndustryIds.forEach(pid => {
        evaluationState[pid] = { 
            criteria: {}, 
            totalScore: 0 
        };
        // Khởi tạo điểm mặc định (ví dụ 5.0) cho từng tiêu chí của mỗi location
        sliders.forEach(slider => {
            const critId = slider.dataset.criteriaId;
            evaluationState[pid].criteria[critId] = parseFloat(slider.value);
        });
    });

    const centerX = 100, centerY = 100, radius = 80;

    // 3. Hàm tính tọa độ điểm (Build Points)
    function getPointCoordinates(criteriaData) {
        let points = [];
        sliders.forEach((slider, i) => {
            const critId = slider.dataset.criteriaId;
            const score = criteriaData[critId] || 0;
            const max = parseFloat(slider.max) || 10;
            
            const angle = (Math.PI * 2 * i / numCriteria) - (Math.PI / 2);
            const valRadius = (score / max) * radius;
            const x = centerX + valRadius * Math.cos(angle);
            const y = centerY + valRadius * Math.sin(angle);
            points.push(`${x},${y}`);
        });
        return points.length > 0 ? `M ${points.join(' L ')} Z` : '';
    }

    // 4. Hàm Render Radar (Vẽ nhiều lớp)
    function renderRadar() {
      const polygonContainer = document.getElementById('radar-polygons');
      const dotsContainer = document.getElementById('radar-dots');

      polygonContainer.innerHTML = '';
      dotsContainer.innerHTML = '';

      projectIndustryIds.forEach(pid => {
          const criteriaData = evaluationState[pid].criteria;
          const points = getPointCoordinates(criteriaData);
          if (!points) return;

          const color = getIndustryColor(pid);
          const isActive = pid === activeProjectIndustryId;

          // ===== Polygon =====
          const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
          path.setAttribute("d", points);
          path.setAttribute("fill", color);
          path.setAttribute("fill-opacity", isActive ? "0.35" : "0.18");
          path.setAttribute("stroke", color);
          path.setAttribute("stroke-width", isActive ? "2.5" : "1.2");
          path.style.transition = "all 0.3s ease";

          polygonContainer.appendChild(path);

          // ===== Dots (chỉ active) =====
          if (isActive) {
            sliders.forEach((slider, i) => {
                const score = criteriaData[slider.dataset.criteriaId];
                const max = parseFloat(slider.max) || 10;
                const angle = (Math.PI * 2 * i / numCriteria) - (Math.PI / 2);
                const valRadius = (score / max) * radius;

                    const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                    circle.setAttribute("cx", centerX + valRadius * Math.cos(angle));
                    circle.setAttribute("cy", centerY + valRadius * Math.sin(angle));
                    circle.setAttribute("r", "3");
                    circle.setAttribute("fill", color);
                    circle.setAttribute("stroke", "#fff");
                    circle.setAttribute("stroke-width", "1");
                    dotsContainer.appendChild(circle);
                });
            }
        });
    }


    // 5. Hàm cập nhật điểm tổng (Total Score)
    function updateHeaderScore() {
        let totalWeightedScore = 0;
        let maxTotalScore = 0;

        sliders.forEach(slider => {
            const score = evaluationState[activeProjectIndustryId].criteria[slider.dataset.criteriaId];
            const weight = (parseFloat(slider.dataset.weight) || 0) / 100;
            const max = parseFloat(slider.max) || 10;

            totalWeightedScore += score * weight;
            maxTotalScore += max * weight;
        });
        
        evaluationState[activeProjectIndustryId].totalScore = parseFloat(totalWeightedScore.toFixed(2));
        document.getElementById('total-score-display').innerText = totalWeightedScore.toFixed(1);
        document.getElementById('total-score-max').innerText = maxTotalScore.toFixed(1);
        const totalScoreInput = document.getElementById('total-score-input');
        if (totalScoreInput) {
            totalScoreInput.value = totalWeightedScore.toFixed(2);
        }
    }

    // 6. Xử lý chuyển đổi Tab
    document.querySelectorAll('.location-tab').forEach(btn => {
        btn.addEventListener('click', function() {
            // Cập nhật UI Tab
            document.querySelectorAll('.location-tab').forEach(b => {
                b.classList.remove('active', 'border-b-primary', 'text-primary');
                b.classList.add('text-[#617589]', 'border-transparent');
            });
            this.classList.add('active', 'border-b-primary', 'text-primary');
            this.classList.remove('text-[#617589]', 'border-transparent');

            activeProjectIndustryId = this.dataset.projectIndustryId;
            
            // Cập nhật tên Header
            const locationName = this.querySelector('span:last-child').innerText;
            document.querySelector('h2.text-xl').innerText = `Evaluation: ${locationName}`;

            // Đồng bộ Sliders với dữ liệu của Industry này
            sliders.forEach(slider => {
                const critId = slider.dataset.criteriaId;
                if (evaluationState[activeProjectIndustryId].criteria[critId] === undefined) {
                    evaluationState[activeProjectIndustryId].criteria[critId] = 0;
                }
                const val = evaluationState[activeProjectIndustryId].criteria[critId];
                slider.value = val;
                slider.closest('.group').querySelector('.score-value').innerText = val.toFixed(1);
                // Đổi màu số hiển thị cho khớp với màu radar của industry đó
                slider.closest('.group').querySelector('.score-value').style.color = getIndustryColor(activeProjectIndustryId);
            });

            updateHeaderScore();
            renderRadar();
        });
    });

    // 7. Xử lý khi kéo Sliders
    sliders.forEach(slider => {
        slider.addEventListener('input', function() {
            const score = parseFloat(this.value);
            evaluationState[activeProjectIndustryId].criteria[this.dataset.criteriaId] = score;
            this.closest('.group').querySelector('.score-value').innerText = score.toFixed(1);
            
            updateHeaderScore();
            renderRadar();
        });
    });

    // 8. Khởi tạo Grid & Trục (Chỉ chạy 1 lần)
    function initChartLayout() {
        const gridContainer = document.getElementById('radar-grid');
        const axesContainer = document.getElementById('radar-axes');
        const labelsContainer = document.getElementById('radar-labels');

        gridContainer.innerHTML = ''; axesContainer.innerHTML = ''; labelsContainer.innerHTML = '';

        [0.25, 0.5, 0.75, 1].forEach(level => {
            let pts = [];
            for (let i = 0; i < numCriteria; i++) {
                const angle = (Math.PI * 2 * i / numCriteria) - (Math.PI / 2);
                pts.push(`${centerX + radius * level * Math.cos(angle)},${centerY + radius * level * Math.sin(angle)}`);
            }
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", `M ${pts.join(' L ')} Z`);
            gridContainer.appendChild(path);
        });

        sliders.forEach((slider, i) => {
            const angle = (Math.PI * 2 * i / numCriteria) - (Math.PI / 2);
            const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
            line.setAttribute("x1", centerX); line.setAttribute("y1", centerY);
            line.setAttribute("x2", centerX + radius * Math.cos(angle));
            line.setAttribute("y2", centerY + radius * Math.sin(angle));
            axesContainer.appendChild(line);

            const label = document.createElement('span');
            label.className = "absolute text-[9px] font-bold text-[#617589] uppercase tracking-wider text-center w-20 leading-tight";
            label.innerText = slider.dataset.name;
            const lx = centerX + (radius + 15) * Math.cos(angle);
            const ly = centerY + (radius + 15) * Math.sin(angle);
            label.style.left = `${(lx / 200) * 100}%`;
            label.style.top = `${(ly / 200) * 100}%`;
            label.style.transform = 'translate(-50%, -50%)';
            labelsContainer.appendChild(label);
        });
    }

    initChartLayout();
    updateHeaderScore();
    renderRadar();
});

document.getElementById('evaluation-form').addEventListener('submit', function (e) {
    document.querySelectorAll('.dynamic-input').forEach(el => el.remove());

    const form = this;

    Object.keys(evaluationState).forEach(projectIndustryId => {
        const state = evaluationState[projectIndustryId];

        // total score
        appendHidden(form, `evaluations[${projectIndustryId}][total_score]`, state.totalScore);

        // criteria
        Object.keys(state.criteria).forEach(criteriaId => {
            const slider = document.querySelector(`[data-criteria-id="${criteriaId}"]`);
            appendHidden(form,
                `evaluations[${projectIndustryId}][criteria][${criteriaId}][score]`,
                state.criteria[criteriaId]
            );

            appendHidden(form,
                `evaluations[${projectIndustryId}][criteria][${criteriaId}][criteria_percentage]`,
                slider.dataset.weight
            );

            appendHidden(form,
                `evaluations[${projectIndustryId}][criteria][${criteriaId}][criteria_name]`,
                slider.dataset.name
            );
        });
    });
});

function appendHidden(form, name, value) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    input.classList.add('dynamic-input');
    form.appendChild(input);
}

</script>
@endsection