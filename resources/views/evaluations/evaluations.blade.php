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
</style>
@endpush
@section('content')
<main class="flex-1 w-full max-w-[1440px] mx-auto p-4 md:p-8 lg:p-10 gap-6 flex flex-col">
  <!-- Breadcrumbs -->
  <div class="flex flex-wrap gap-2 items-center text-sm">
    <a class="text-[#617589] hover:text-primary transition-colors font-medium" href="#">Home</a>
    <span class="material-symbols-outlined text-[#617589] text-[16px]">chevron_right</span>
    <a class="text-[#617589] hover:text-primary transition-colors font-medium" href="#">Projects</a>
    <span class="material-symbols-outlined text-[#617589] text-[16px]">chevron_right</span>
    <span class="text-[#111418] dark:text-white font-semibold">Q3 Retail Expansion</span>
  </div>
  <!-- Page Header -->
  <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
    <div class="flex flex-col gap-2">
      <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">Q3 Retail Expansion</h1>
      <div class="flex flex-wrap items-center gap-3 text-[#617589] text-sm">
        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider">In
          Progress</span>
        <span>•</span>
        <span>Project ID: {{ old('project_id', $project->project_id) }}</span>
        <span>•</span>
        <span>Created on {{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('M d, Y')) }}</span>
      </div>
    </div>
    <div class="flex gap-3">
      <button
        class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-white dark:bg-[#2d3748] border border-[#dbe0e6] dark:border-[#4a5568] text-[#111418] dark:text-white text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-[#374151] transition-colors gap-2">
        <span class="material-symbols-outlined text-[18px]">edit</span>
        <span class="truncate">Edit Project</span>
      </button>
      <button
        class="flex cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary/90 transition-colors gap-2">
        <span class="material-symbols-outlined text-[18px]">download</span>
        <span class="truncate">Export Report</span>
      </button>
    </div>
  </div>
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
          <span class="material-symbols-outlined text-[#617589]">info</span>
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
            <div class="flex flex-col gap-1 pb-4 border-b border-[#f0f2f4] dark:border-[#2d3748]">
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
              <p class="font-medium">{{ old('end_date', \Carbon\Carbon::parse($project->end_date)->format('M d, Y')) }}</p>
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
        <button
          class="flex items-center gap-2 border-b-[3px] border-b-primary text-primary pb-3 px-1 whitespace-nowrap outline-none group">
          <span class="material-symbols-outlined text-[20px]">storefront</span>
          <span class="text-sm font-bold tracking-[0.015em]">Downtown Store</span>
        </button>
        <!-- <button
          class="flex items-center gap-2 border-b-[3px] border-b-transparent text-[#617589] hover:text-[#111418] dark:hover:text-white pb-3 px-1 whitespace-nowrap transition-colors outline-none group">
          <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">cottage</span>
          <span class="text-sm font-bold tracking-[0.015em]">Suburb Location</span>
        </button>
        <button
          class="flex items-center gap-2 border-b-[3px] border-b-transparent text-[#617589] hover:text-[#111418] dark:hover:text-white pb-3 px-1 whitespace-nowrap transition-colors outline-none group">
          <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">flight</span>
          <span class="text-sm font-bold tracking-[0.015em]">Airport Kiosk</span>
        </button> -->
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
              <p class="text-2xl font-black text-primary leading-none">7.2 <span
                  class="text-sm text-[#617589] font-medium">/ 10</span></p>
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
            <!-- Criterion 1 -->
            <div class="group">
              <div class="flex justify-between items-end mb-2">
                <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#617589] text-[18px]">directions_walk</span>
                  Foot Traffic {{ old('')}}
                </label>
                <span class="font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">8.0</span>
              </div>
              <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" max="10"
                min="1" step="0.5" type="range" value="8" />
              <div class="flex justify-between text-xs text-[#617589] mt-1">
                <span>Low</span>
                <span>High</span>
              </div>
            </div>
            <!-- Criterion 2 -->
            <div class="group">
              <div class="flex justify-between items-end mb-2">
                <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#617589] text-[18px]">attach_money</span>
                  Rent Affordability
                </label>
                <span class="font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">6.5</span>
              </div>
              <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" max="10"
                min="1" step="0.5" type="range" value="6.5" />
            </div>
            <!-- Criterion 3 -->
            <div class="group">
              <div class="flex justify-between items-end mb-2">
                <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#617589] text-[18px]">visibility</span>
                  Visibility
                </label>
                <span class="font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">9.0</span>
              </div>
              <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" max="10"
                min="1" step="0.5" type="range" value="9" />
            </div>
            <!-- Criterion 4 -->
            <div class="group">
              <div class="flex justify-between items-end mb-2">
                <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#617589] text-[18px]">foundation</span>
                  Site Condition
                </label>
                <span class="font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">4.0</span>
              </div>
              <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" max="10"
                min="1" step="0.5" type="range" value="4" />
            </div>
            <!-- Criterion 5 -->
            <div class="group">
              <div class="flex justify-between items-end mb-2">
                <label class="font-bold text-sm text-[#111418] dark:text-white flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#617589] text-[18px]">local_parking</span>
                  Parking
                </label>
                <span class="font-bold text-primary text-sm bg-primary/10 px-2 py-0.5 rounded">8.5</span>
              </div>
              <input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" max="10"
                min="1" step="0.5" type="range" value="8.5" />
            </div>
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
              <svg class="w-full h-full drop-shadow-lg" viewbox="0 0 200 200">
                <!-- Grid Web (Pentagon) -->
                <g class="stroke-[#dbe0e6] dark:stroke-[#4a5568]" fill="none" stroke-width="1">
                  <!-- Outer -->
                  <path d="M100 10 L185.5 72.1 L152.9 172.4 H47.1 L14.5 72.1 Z"></path>
                  <!-- 75% -->
                  <path d="M100 32.5 L164.1 79.1 L139.7 154.3 H60.3 L35.9 79.1 Z" opacity="0.6"></path>
                  <!-- 50% -->
                  <path d="M100 55 L142.7 86.1 L126.5 136.2 H73.5 L57.3 86.1 Z" opacity="0.4"></path>
                  <!-- 25% -->
                  <path d="M100 77.5 L121.4 93.1 L113.2 118.1 H86.8 L78.6 93.1 Z" opacity="0.2"></path>
                </g>
                <!-- Axes -->
                <g class="stroke-[#dbe0e6] dark:stroke-[#4a5568]" stroke-dasharray="2 2" stroke-width="1">
                  <line x1="100" x2="100" y1="100" y2="10"></line>
                  <line x1="100" x2="185.5" y1="100" y2="72.1"></line>
                  <line x1="100" x2="152.9" y1="100" y2="172.4"></line>
                  <line x1="100" x2="47.1" y1="100" y2="172.4"></line>
                  <line x1="100" x2="14.5" y1="100" y2="72.1"></line>
                </g>
                <path class="drop-shadow-sm transition-all duration-500 ease-in-out"
                  d="M100 28 L155 82 L148 165 H65 L25 80 Z" fill="#137fec" fill-opacity="0.2" stroke="#137fec"
                  stroke-width="2.5"></path>
                <!-- Data Points -->
                <circle class="animate-pulse" cx="100" cy="28" fill="#137fec" r="3"></circle>
                <circle cx="155" cy="82" fill="#137fec" r="3"></circle>
                <circle cx="148" cy="165" fill="#137fec" r="3"></circle>
                <circle cx="65" cy="165" fill="#137fec" r="3"></circle>
                <circle cx="25" cy="80" fill="#137fec" r="3"></circle>
              </svg>
              <!-- Labels positioned absolutely for easier styling -->
              <span
                class="absolute top-0 left-1/2 -translate-x-1/2 -mt-4 text-[10px] font-bold text-[#617589] uppercase tracking-wider bg-surface-light dark:bg-surface-dark px-1 rounded">Foot
                Traffic</span>
              <span
                class="absolute top-[35%] right-0 -mr-6 text-[10px] font-bold text-[#617589] uppercase tracking-wider text-right w-16 leading-tight">Rent<br />Afford.</span>
              <span
                class="absolute bottom-[15%] right-0 -mr-2 text-[10px] font-bold text-[#617589] uppercase tracking-wider">Visibility</span>
              <span
                class="absolute bottom-[15%] left-0 -ml-2 text-[10px] font-bold text-[#617589] uppercase tracking-wider">Condition</span>
              <span
                class="absolute top-[35%] left-0 -ml-8 text-[10px] font-bold text-[#617589] uppercase tracking-wider w-16 leading-tight">Parking</span>
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
              <textarea
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
@endsection