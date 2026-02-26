@extends('layouts.app')
@section('title','Project Detail')

@push('styles')
<style>
body { font-family: 'Manrope', sans-serif; }
::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">

    <!-- Breadcrumb -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] hover:text-primary" href="{{ route('admin.screen') }}">Dashboard</a>
      <span class="text-[#617589]">/</span>
      <a class="text-[#617589] hover:text-primary" href="{{ route('projects.screen') }}">Projects</a>
      <span class="text-[#617589]">/</span>
      <span class="text-[#111418] dark:text-white font-medium">Project Detail</span>
    </div>

    <!-- Header -->
    <div class="flex justify-between items-end px-4">
      <div>
        <h1 class="text-4xl font-black text-[#111418] dark:text-white">Project Detail</h1>
        <p class="text-[#617589] dark:text-gray-400">View project information and evaluation criteria.</p>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('projects.screen') }}"
          class="h-10 px-4 flex items-center border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
          Back
        </a>
      </div>
    </div>

    <!-- GENERAL INFO -->
    <div class="bg-white dark:bg-[#1a2632] rounded-xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm">
      <h2 class="px-6 py-5 text-[22px] font-bold border-b border-[#f0f2f4] dark:border-gray-700 text-[#111418] dark:text-white">
        General Information
      </h2>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-2">
          <span class="text-sm text-[#617589] dark:text-gray-400">Project Name</span>
          <p class="font-medium text-[#111418] dark:text-white mt-1">{{ $project->project_name }}</p>
        </div>
        <div class="col-span-2">
          <span class="text-sm text-[#617589] dark:text-gray-400">Description</span>
          <div class="mt-1 bg-gray-50 dark:bg-[#253240] p-4 rounded-lg text-sm text-[#111418] dark:text-white">
            {{ $project->description ?? '—' }}
          </div>
        </div>
        <div>
          <span class="text-sm text-[#617589] dark:text-gray-400">Start Date</span>
          <p class="font-medium text-[#111418] dark:text-white mt-1">
            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '—' }}
          </p>
        </div>
        <div>
          <span class="text-sm text-[#617589] dark:text-gray-400">End Date</span>
          <p class="font-medium text-[#111418] dark:text-white mt-1">
            {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : '—' }}
          </p>
        </div>
      </div>
    </div>

    <!-- ASSIGNMENTS -->
    <div class="bg-white dark:bg-[#1a2632] rounded-xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm">
      <h2 class="px-6 py-5 text-[22px] font-bold border-b border-[#f0f2f4] dark:border-gray-700 text-[#111418] dark:text-white">
        Assignments
      </h2>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <span class="text-sm text-[#617589] dark:text-gray-400">Client</span><br>
          @if($project->client)
            <span class="inline-block mt-2 bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">
              {{ $project->client->client_name }}
            </span>
          @else
            <span class="text-[#111418] dark:text-white">—</span>
          @endif
        </div>
        <div>
          <span class="text-sm text-[#617589] dark:text-gray-400">Locations</span><br>
          @php $industries = $project->industries; @endphp
          @forelse($industries as $industry)
            <span class="inline-block mt-2 mr-1 bg-green-500/10 text-green-600 px-3 py-1 rounded-full text-sm font-medium">
              {{ $industry->industry_name }}
            </span>
          @empty
            <span class="text-[#111418] dark:text-white">—</span>
          @endforelse
        </div>
      </div>
    </div>

    <!-- EVALUATION CRITERIA với Location Tabs -->
    @php
      $criteriaByIndustry = $project->projectCriteria
          ->groupBy('industry_id'); // key = industry_id (int|null)

      $industries = $project->industries; // collection Industry
    @endphp

    <div class="bg-white dark:bg-[#1a2632] rounded-xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm overflow-hidden">

      <!-- Location Tabs -->
      @if($industries->isNotEmpty())
      <div class="flex gap-2 px-6 pt-4 overflow-x-auto border-b dark:border-gray-700" id="detail-location-tabs">
        @foreach($industries as $index => $industry)
          <button
            type="button"
            onclick="switchDetailTab({{ $industry->id }})"
            id="tab-btn-{{ $industry->id }}"
            class="px-4 py-2 rounded-t-lg text-sm font-medium transition-all whitespace-nowrap
              {{ $index === 0 ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
            {{ $industry->industry_name }}
          </button>
        @endforeach
      </div>
      @endif

      <!-- Header section -->
      <div class="px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
        <h2 class="text-[22px] font-bold text-[#111418] dark:text-white">Evaluation Criteria</h2>
        <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Evaluation metrics per location.</p>
      </div>

      <!-- Tab Panels: 1 panel per industry -->
      @forelse($industries as $index => $industry)
        @php
          $parentCriteriaList = $criteriaByIndustry->get($industry->id, collect());
        @endphp

        <div
          id="tab-panel-{{ $industry->id }}"
          class="p-6 {{ $index !== 0 ? 'hidden' : '' }}">

          <!-- Column headers -->
          <div class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>
            <div class="col-span-2">Type</div>
            <div class="col-span-4">Value</div>
          </div>

          @forelse($parentCriteriaList as $parent)
            <div class="mb-6 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm">

              <!-- Parent row -->
              <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 dark:bg-gray-800/50 px-4 py-3 border-b dark:border-gray-700">
                <div class="col-span-4 font-bold text-primary flex items-center gap-2 text-sm">
                  <span class="material-symbols-outlined text-base">folder</span>
                  {{ $parent->criteria->criteria_name ?? 'ID: '.$parent->criteria_id }}
                </div>
                <div class="col-span-2">
                  <span class="inline-block bg-primary/10 text-primary text-sm font-bold px-3 py-1 rounded-lg">
                    {{ $parent->weight }}%
                  </span>
                </div>
                <div class="col-span-6 text-xs text-gray-400 italic">Main criterion weight</div>
              </div>

              <!-- Children rows -->
              <div class="divide-y divide-gray-50 dark:divide-gray-700/50 bg-white dark:bg-[#1a2632]">
                @forelse($parent->targets as $child)
                  <div class="grid grid-cols-12 gap-4 items-center px-4 py-3">

                    <!-- Child name -->
                    <div class="col-span-4 text-sm pl-6 flex items-center gap-2 dark:text-gray-300">
                      <span class="text-gray-300 dark:text-gray-600 text-xs">└</span>
                      {{ $child->criteria->criteria_name ?? 'ID: '.$child->criteria_id }}
                    </div>

                    <!-- Weight -->
                    <div class="col-span-2">
                      <span class="text-sm font-medium text-[#111418] dark:text-white">
                        {{ $child->weight }}%
                      </span>
                    </div>

                    <!-- Type -->
                    <div class="col-span-2">
                      @if($child->criteriaType)
                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs px-2 py-1 rounded">
                          {{ $child->criteriaType->name }}
                        </span>
                      @else
                        <span class="text-gray-400 text-xs">—</span>
                      @endif
                    </div>

                    <!-- Target value -->
                    <div class="col-span-4">
                      @php
                        $typeId = $child->criteria_type_id;
                        $val    = $child->target_value;
                      @endphp

                      @if($typeId == 4) {{-- yes/no --}}
                        @if($val === 'yes')
                          <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Yes
                          </span>
                        @elseif($val === 'no')
                          <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">cancel</span> No
                          </span>
                        @else
                          <span class="text-gray-400 text-xs">—</span>
                        @endif

                      @elseif($typeId == 3) {{-- 2H4R/4H9R --}}
                        @if($val)
                          <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $val }}
                          </span>
                        @else
                          <span class="text-gray-400 text-xs">—</span>
                        @endif

                      @else
                        <span class="text-sm text-[#111418] dark:text-white">
                          {{ $val ?: '—' }}
                        </span>
                      @endif
                    </div>

                  </div>
                @empty
                  <p class="text-xs text-gray-400 dark:text-gray-500 px-6 py-3 italic">No sub-criteria.</p>
                @endforelse
              </div>

            </div>
          @empty
            <div class="text-center py-10 text-gray-400 dark:text-gray-500">
              <span class="material-symbols-outlined text-4xl mb-2 block">playlist_add</span>
              <p class="text-sm">No criteria assigned for this location.</p>
            </div>
          @endforelse

        </div>

      @empty
        <!-- Không có location nào -->
        <div class="p-6 text-center text-gray-400 dark:text-gray-500 py-10">
          <span class="material-symbols-outlined text-4xl mb-2 block">location_off</span>
          <p class="text-sm">No locations assigned to this project.</p>
        </div>
      @endforelse

    </div>

  </div>
</main>

<script>
// Tab switching logic
function switchDetailTab(industryId) {
    // Ẩn tất cả panels
    document.querySelectorAll('[id^="tab-panel-"]').forEach(p => p.classList.add('hidden'));

    // Bỏ active tất cả tab buttons
    document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
        btn.className = btn.className
            .replace('bg-primary text-white', '')
            .trim();
        btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-300', 'hover:bg-gray-200');
    });

    // Hiện panel được chọn
    const panel = document.getElementById('tab-panel-' + industryId);
    if (panel) panel.classList.remove('hidden');

    // Active tab button được chọn
    const btn = document.getElementById('tab-btn-' + industryId);
    if (btn) {
        btn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-300', 'hover:bg-gray-200');
        btn.classList.add('bg-primary', 'text-white');
    }
}
</script>

@endsection