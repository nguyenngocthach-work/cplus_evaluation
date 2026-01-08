@extends('layouts.app')
@section('title','Manage Projects')
@push('styles')
<style>
body {
  font-family: 'Manrope', sans-serif;
}

/* Custom scrollbar for better look in containers */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
@endpush
@section('content')
<!-- Top Navigation -->
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors"
        href="{{ route('admin.screen') }}">Dashboard</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors"
        href="#">Projects</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <span class="text-[#111418] dark:text-white text-base font-medium leading-normal">Update Project</span>
    </div>
    <!-- Page Header -->
    <div class="flex flex-wrap justify-between items-end gap-3 px-4">
      <div class="flex min-w-72 flex-col gap-3">
        <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Update
          Project</h1>
        <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">Configure project details,
          assign stakeholders, and set evaluation metrics.</p>
      </div>
      <div class="flex gap-3">
        <button
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-transparent text-[#111418] dark:text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-300 dark:border-gray-600 transition-all">
          <span class="truncate">Cancel</span>
        </button>
        <button type="button" onclick="document.getElementById('project-form').submit()"
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-blue-600 shadow-md transition-all">
          <span class="truncate">Save Project</span>
        </button>
      </div>
    </div>
    <!-- Main Form Content -->
    <form id="project-form" method="POST" action="{{ route('projects.update', $project->project_id) }}" class="flex flex-col gap-6">
      <!-- Section 1: General Information -->
      @csrf
      @method('PUT')
      <div
        class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <h2
          class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          General Information
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <label class="flex flex-col gap-2 col-span-2 md:col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Project Name <span
                class="text-red-500">*</span></span>
            <input name="project_name" value="{{ old('project_name', $project->project_name) }}"
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589] dark:placeholder:text-gray-500"
              placeholder="e.g. Q4 Regional Retail Expansion" required="" type="text" />
          </label>
          <label class="flex flex-col gap-2 col-span-2 md:col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Description</span>
            <textarea name="description"
              class="form-textarea w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white p-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589] dark:placeholder:text-gray-500 resize-none h-32"
              placeholder="Briefly describe the goals and scope of this project...">{{ old('description', $project->description) }}</textarea>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Start Date</span>
            <div class="relative">
              <input id="start-date" name="start_date" value="{{ old('start_date', $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                type="date" />
            </div>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">End Date</span>
            <div class="relative">
              <input id="end-date" name="end_date" value="{{ old('end_date', $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '') }}"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                type="date" />
            </div>
          </label>
        </div>
      </div>
      <!-- Section 2: Assignments -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 ">
        <h2
          class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          Assignments
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Clients Assignment -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Assign
              Clients</label>
            <div class="relative group">
              <div
                class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all cursor-text">
                <span class="material-symbols-outlined text-[#617589] mr-2">search</span>
                <div class="flex flex-wrap gap-2 flex-1">
                  <input id="client-search"
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white"
                    placeholder="Search clients..." type="text" />
                </div>
                <span
                  class="material-symbols-outlined text-[#617589] cursor-pointer hover:text-primary">expand_more</span>
              </div>
              <!-- Dropdown simulation -->
              <div id="client-dropdown"
                class="absolute top-full z-40 left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg hidden group-focus-within:block max-h-48 overflow-y-auto">
                <!-- Dropdown area -->
              </div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Select the clients associated with this project.</p>
          </div>
          <!-- Locations Assignment -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Assign
              Locations</label>
            <div class="relative group">
              <div
                class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all cursor-text">
                <span class="material-symbols-outlined text-[#617589] mr-2">location_on</span>
                <div class="flex flex-wrap gap-2 flex-1">
                  <input id="location-search"
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white"
                    placeholder="Search locations..." type="text" />
                </div>
                <span
                  class="material-symbols-outlined text-[#617589] cursor-pointer hover:text-primary">expand_more</span>
              </div>
              <!-- Dropdown simulation -->
              <div id="location-dropdown"
                class="absolute top-full left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg z-10 hidden group-focus-within:block max-h-48 overflow-y-auto">
                <!-- dropdown location area -->
              </div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Specify where this project will be executed.</p>
          </div>
        </div>
      </div>
      <!-- Section 3: Evaluation Criteria -->
      <div id="evaluation-criteria-list"
        class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          <div class="flex flex-col">
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]">
              Evaluation Criteria</h2>
            <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Define the metrics used to evaluate success.
              Weights must sum to 100%.</p>
          </div>
          <button onclick="openCriteriaModal()"
            class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-lg transition-colors"
            type="button">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Add Criterion
          </button>
        </div>
        <div class="p-6" id="criteria-rows-container">
          <!-- Header Row -->
          <div
            class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>
            <div class="col-span-5">Description</div>
            <div class="col-span-1 text-center">Action</div>
          </div>
          <div id="criteria-items-list">
            <div
              class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start mb-6 md:mb-4 pb-4 md:pb-0 border-b md:border-b-0 border-[#f0f2f4] dark:border-gray-700 last:mb-0">
            </div>
          </div>
          <!-- selectCriteria area -->
          <!-- Total Weight Summary -->
          <div class="mt-6 flex justify-end items-center gap-4 pt-4 border-t border-[#f0f2f4] dark:border-gray-700">
            <span class="text-sm font-medium text-[#617589] dark:text-gray-400">Total Weight:</span>
            <div class="flex items-center gap-2">
              <span id="total-weight-display" class="text-lg font-bold text-[#111418] dark:text-white">0%</span>
              <span id="total-weight-warning" class="flex items-center gap-1 text-amber-500 hidden">
                <span class="material-symbols-outlined text-amber-500 text-base"
                  title="Total must be 100%">warning</span>
                <span class="text-xs text-amber-500 font-medium">Must equal 100%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Actions (Mobile Sticky) -->
      <div
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#1a2632] border-t border-[#f0f2f4] dark:border-gray-700 p-4 md:hidden z-40 flex gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <button class="flex-1 h-12 rounded-lg bg-gray-100 text-[#111418] font-bold text-sm">Cancel</button>
        <button class="flex-1 h-12 rounded-lg bg-primary text-white font-bold text-sm">Save Project</button>
      </div>
      <!-- Spacer for mobile footer -->
      <div class="h-16 md:hidden"></div>
    </form>
  </div>

  <!-- Criteria Modal -->
  <div id="criteriaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-[#1a2632] rounded-xl w-full max-w-lg shadow-lg">
      <!-- Header -->
      <div class="flex justify-between items-center px-6 py-4 border-b">
        <h3 class="text-lg font-bold">Select Criteria</h3>
        <button onclick="closeCriteriaModal()">✕</button>
      </div>

      <!-- Body -->
      <div class="p-4 max-h-80 overflow-y-auto">
        @foreach($project->criteria as $item)
        <div onclick="selectCriteria({{ json_encode($item) }})"
          class="flex justify-between items-center px-4 py-3 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700">
          <div>
            <p class="font-medium">{{ $item->criteria_name }}</p>
            <p class="text-xs text-gray-500">{{ $item->description }}</p>
          </div>
          <span class="text-sm text-primary font-bold">
            {{ $item->criteriaPercent }}%
          </span>
        </div>
        @endforeach
      </div>

      <!-- Footer -->
      <div class="px-6 py-3 border-t text-right">
        <button onclick="closeCriteriaModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
          Close
        </button>
      </div>
    </div>
  </div>

  <script>
  // clients list
  const clientInput = document.getElementById('client-search');
  const clientDropdown = document.getElementById('client-dropdown');

  let clientSelected = [];

  clientInput.addEventListener('input', async function() {
    const keyword = this.value.trim();
    if (keyword.length < 2) {
      clientDropdown.classList.add('hidden');
      return;
    }

    const res = await fetch(`/clients/search?keyword=${encodeURIComponent(keyword)}`);
    const dataClient = await res.json();

    clientDropdown.innerHTML = '';
    dataClient.forEach(client => {
      const div = document.createElement('div');
      div.className =
        'px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm flex items-center gap-2';
      div.textContent = client.client_name;

      div.onclick = () => addClient(client);
      clientDropdown.appendChild(div);
    });

    clientDropdown.classList.remove('hidden');
  });

  function addClient(client) {
    if (clientSelected.find(c => c.id === client.id)) return;

    clientSelected.push(client);

    const container = clientInput.parentElement;

    const tag = document.createElement('div');
    tag.className =
      'flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded text-sm font-medium';

    tag.innerHTML = `
    ${client.client_name}
    <button type="button" class="ml-1">✕</button>
    <input type="hidden" name="clients[]" value="${client.id}">
  `;

    tag.querySelector('button').onclick = () => {
      clientSelected = clientSelected.filter(c => c.id !== client.id);
      tag.remove();
    };

    container.insertBefore(tag, clientInput);

    clientInput.value = '';
    clientDropdown.classList.add('hidden');
  }


  // locations list
  const locationInput = document.getElementById('location-search');
  const locationDropdown = document.getElementById('location-dropdown');
  let selectedLocations = [];

  locationInput.addEventListener('input', async function() {
    const keyword = this.value.trim();
    if (keyword.length < 2) {
      locationDropdown.classList.add('hidden');
      return;
    }

    const res = await fetch(`/locations/search?keyword=${encodeURIComponent(keyword)}`);
    console.log(res)
    const data = await res.json();

    locationDropdown.innerHTML = '';
    data.forEach(location => {
      const div = document.createElement('div');
      div.className =
        'px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm';
      div.textContent = location.industry_name;
      div.onclick = () => addLocation(location);
      locationDropdown.appendChild(div);
    });

    locationDropdown.classList.remove('hidden');
  });

  function addLocation(location) {
    if (selectedLocations.find(l => l.id === location.id)) return;
    selectedLocations.push(location);

    const container = locationInput.parentElement;

    const tag = document.createElement('div');
    tag.className = 'flex items-center gap-1 bg-green-500/10 text-green-600 px-2 py-1 rounded text-sm font-medium';
    tag.innerHTML = `
    ${location.industry_name}
    <button type="button" class="ml-1">✕</button>
    <input type="hidden" name="locations[]" value="${location.id}">
  `;

    tag.querySelector('button').onclick = () => {
      selectedLocations = selectedLocations.filter(l => l.id !== location.id);
      tag.remove();
    };

    container.insertBefore(tag, locationInput);
    locationInput.value = '';
    locationDropdown.classList.add('hidden');
  }

  // criteria list
  function openCriteriaModal() {
    document.getElementById('criteriaModal').classList.remove('hidden');
    document.getElementById('criteriaModal').classList.add('flex');
  }

  function closeCriteriaModal() {
    document.getElementById('criteriaModal').classList.add('hidden');
    document.getElementById('criteriaModal').classList.remove('flex');
  }

  // container criteria render
  const criteriaContainer = document.querySelector('#evaluation-criteria-list');

  function selectCriteria(criteria) {
    if (document.getElementById(`criteria-${criteria.id}`)) return;


    const rowsContainer = document.getElementById('criteria-items-list');

    const row = document.createElement('div');
    row.id = `criteria-${criteria.id}`;
    row.className =
      `grid grid-cols-1 md:grid-cols-12 gap-4 items-start mb-6 md:mb-4 pb-4 md:pb-0 border-b md:border-b-0 border-[#f0f2f4] dark:border-gray-700 last:mb-0`;

    row.innerHTML = `
        <input type="hidden" name="criteria_ids[]" value="${criteria.id}">
        <div class="col-span-1 md:col-span-4">
            <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Name</label>
            <input class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary" 
                  value="${criteria.criteria_name}" readonly>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Weight (%)</label>
            <div class="relative">
                <input readonly class="criteria-weight-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary pr-8"
                      name="criteria_percent[${criteria.id}]" type="number" 
                      oninput="calculateTotalWeight()" value="${criteria.criteriaPercent}">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
            </div>
        </div>
        <div class="col-span-1 md:col-span-5">
            <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Description</label>
            <input class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                  name="criteria_description[${criteria.id}]" value="${criteria.description ?? ''}">
        </div>
        <div class="col-span-1 flex justify-center items-center h-10">
            <button type="button" onclick="removeCriteria(${criteria.id})" class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                <span class="material-symbols-outlined text-lg">delete</span>
            </button>
        </div>
    `;

    rowsContainer.appendChild(row);
    calculateTotalWeight();
    closeCriteriaModal();
  }

  function calculateTotalWeight() {
    let total = 0;

    const weights = document.querySelectorAll('.criteria-weight-input');

    weights.forEach(input => {
      const value = parseFloat(input.value);
      if (!isNaN(value)) {
        total += value;
      }
    });

    const display = document.getElementById('total-weight-display');
    const warning = document.getElementById('total-weight-warning');

    if (display) {
      display.textContent = total + '%';
    }

    if (warning) {
      if (total === 100) {
        warning.classList.add('hidden');
      } else {
        warning.classList.remove('hidden');
      }
    }
  }

  function removeCriteria(id) {
    document.getElementById(`criteria-${id}`)?.remove();
    calculateTotalWeight();
  }

  const startDateInput = document.getElementById('start-date');
  const endDateInput = document.getElementById('end-date');
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const todayStr = today.toISOString().split('T')[0];
  startDateInput.min = todayStr;

  startDateInput.addEventListener('change', validateDates);
  endDateInput.addEventListener('change', validateDates);

  function validateDates() {
    const startDateValue = startDateInput.value;
    const endDateValue = endDateInput.value;

    if (!startDateValue || !endDateValue) return;

    const startDate = new Date(startDateValue);
    const endDate = new Date(endDateValue);

    if (endDate <= startDate) {
      alert('End Date must be later than Start Date');
      endDateInput.value = '';
    }
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    @if($project->client)
        addClient(@json([
            'id' => $project->client->id,
            'client_name' => $project->client->client_name
        ]));
    @endif

    @if($project->industry)
      addLocation(@json([
          'id' => $project->industry->id,
          'industry_name' => $project->industry->industry_name
      ]));
    @endif
  });

  document.addEventListener('DOMContentLoaded', () => {
      @foreach($project->criteria as $c)
          @php
              $criteriaData = [
                  'id' => $c->id,
                  'criteria_name' => $c->criteria_name,
                  'criteriaPercent' => $c->pivot->weight ?? 0,
                  'description' => $c->pivot->custom_description ?? '',
              ];
          @endphp
          
          selectCriteria({!! json_encode($criteriaData) !!});
      @endforeach
  });
  </script>

</main>
@endsection