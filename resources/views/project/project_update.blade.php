@extends('layouts.app')
@section('title','Update Project')
@push('styles')
<style>
body { font-family: 'Manrope', sans-serif; }
::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

.criteria-group { border-radius: 10px; overflow: hidden; border: 1px solid #e5e7eb; margin-bottom: 10px; }
.criteria-group-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; background: #f8fafc; cursor: pointer; transition: background 0.15s;
}
.dark .criteria-group-header { background: #1e2d3d; }
.criteria-group-header:hover { background: #f0f4f8; }
.dark .criteria-group-header:hover { background: #253240; }
.criteria-group-header .toggle-icon { transition: transform 0.2s; }
.criteria-group-header.open .toggle-icon { transform: rotate(180deg); }
.criteria-children { display: none; padding: 8px 16px 12px; background: #fff; }
.dark .criteria-children { background: #1a2632; }
.criteria-children.open { display: block; }
.child-checkbox-row {
    display: flex; align-items: center; gap: 10px; padding: 8px 4px;
    border-radius: 6px; cursor: pointer; transition: background 0.12s;
}
.child-checkbox-row:hover { background: #f0f4ff; }
.dark .child-checkbox-row:hover { background: #1e2d3d; }
input[type="checkbox"].criteria-cb { width: 16px; height: 16px; accent-color: var(--color-primary, #3b82f6); cursor: pointer; flex-shrink: 0; }
</style>
@endpush

@section('content')
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">

    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium hover:text-primary transition-colors" href="{{ route('admin.screen') }}">Dashboard</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium">/</span>
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium hover:text-primary transition-colors" href="{{ route('projects.screen') }}">Projects</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium">/</span>
      <span class="text-[#111418] dark:text-white text-base font-medium">Update Project</span>
    </div>

    <!-- Page Header -->
    <div class="flex flex-wrap justify-between items-end gap-3 px-4">
      <div class="flex min-w-72 flex-col gap-3">
        <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Update Project</h1>
        <p class="text-[#617589] dark:text-gray-400 text-base font-normal">Configure project details, assign stakeholders, and set evaluation metrics.</p>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('projects.screen') }}"
          class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-transparent text-[#111418] dark:text-white text-sm font-bold border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
          <span class="truncate">Cancel</span>
        </a>
        <button type="button" onclick="submitProjectForm()"
          class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold hover:bg-blue-600 shadow-md transition-all">
          <span class="truncate">Save Changes</span>
        </button>
      </div>
    </div>

    <!-- Main Form -->
    <form id="project-form" method="POST" action="{{ route('projects.update', $project->project_id) }}" class="flex flex-col gap-6">
      @csrf
      @method('PUT')

      <!-- Section 1: General Information (read-only) -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm">
        <h2 class="px-6 py-5 text-[22px] font-bold border-b border-[#f0f2f4] dark:border-gray-700 text-[#111418] dark:text-white">General Information</h2>
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

      <!-- Section 2: Assignments (read-only) -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl border border-[#e5e7eb] dark:border-gray-700 shadow-sm">
        <h2 class="px-6 py-5 text-[22px] font-bold border-b border-[#f0f2f4] dark:border-gray-700 text-[#111418] dark:text-white">Assignments</h2>
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
            @forelse($project->industries as $industry)
              <span class="inline-block mt-2 mr-1 bg-green-500/10 text-green-600 px-3 py-1 rounded-full text-sm font-medium">
                {{ $industry->industry_name }}
              </span>
            @empty
              <span class="text-[#111418] dark:text-white">—</span>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Section 3: Evaluation Criteria -->
      <div id="evaluation-criteria-list" class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">

        <!-- Location Tabs -->
        <div id="location-tabs" class="flex gap-2 px-6 pt-4 overflow-x-auto border-b dark:border-gray-700"></div>

        <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          <div>
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold">Evaluation Criteria</h2>
            <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Define the metrics used to evaluate success. Weights must sum to 100%.</p>
          </div>
        </div>

        <div class="p-6">
          <div class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>
            <div class="col-span-3">Target Value</div>
            <div class="col-span-2 text-left">Type</div>
          </div>
          <div id="criteria-items-list"></div>

          <!-- Total Weight -->
          <div class="mt-6 flex justify-end items-center gap-4 pt-4 border-t border-[#f0f2f4] dark:border-gray-700">
            <span class="text-sm font-medium text-[#617589] dark:text-gray-400">Total Weight:</span>
            <span id="total-weight-display" class="text-lg font-bold text-[#111418] dark:text-white">0%</span>
            <span id="total-weight-warning" class="hidden flex items-center gap-1 text-amber-500 text-xs font-medium">
              <span class="material-symbols-outlined text-base">warning</span> Must equal 100%
            </span>
          </div>
        </div>
      </div>

      <div class="h-16 md:hidden"></div>
    </form>
  </div>
</main>

<script>
// ==================== DATA FROM BLADE ====================
const projectIndustries = @json($project->industries->values());

let evaluationState   = @json($evaluationState);
let currentLocationId = null;

// selectedLocations lấy từ project.industries
let selectedLocations = projectIndustries.map(i => ({ id: i.id, industry_name: i.industry_name }));

// ==================== INIT ====================
document.addEventListener('DOMContentLoaded', function () {
    // Render tabs từ locations đã có
    if (selectedLocations.length > 0) {
        renderLocationTabs();
        switchLocation(selectedLocations[0].id);
    }
});
// ==================== SYNC ====================
function syncStructureToAllLocations() {
    const sourceParents = evaluationState[currentLocationId]?.parents || {};

    selectedLocations.forEach(loc => {
        if (loc.id === currentLocationId) return;
        if (!evaluationState[loc.id]) evaluationState[loc.id] = { parents: {} };

        const targetParents = evaluationState[loc.id].parents;

        Object.keys(targetParents).forEach(pId => {
            if (!sourceParents[pId]) delete targetParents[pId];
        });

        Object.keys(sourceParents).forEach(pId => {
            const srcParent = sourceParents[pId];
            if (!targetParents[pId]) {
                targetParents[pId] = {
                    info: JSON.parse(JSON.stringify(srcParent.info)),
                    weight: '',
                    children: {}
                };
            }
            const targetChildren = targetParents[pId].children;
            const srcChildren    = srcParent.children;

            Object.keys(targetChildren).forEach(cId => {
                if (!srcChildren[cId]) delete targetChildren[cId];
            });
            Object.keys(srcChildren).forEach(cId => {
                if (!targetChildren[cId]) {
                    targetChildren[cId] = {
                        info: JSON.parse(JSON.stringify(srcChildren[cId].info)),
                        percentage: '',
                        value: '',
                        typeId: srcChildren[cId].typeId ?? srcChildren[cId].info?.criteriaTypeId ?? null,
                        originalPercent: srcChildren[cId].info.criteriaPercent ?? 0
                    };
                }
            });
        });
    });
}

// ==================== LOCATION TABS ====================
function renderLocationTabs() {
    const tabs = document.getElementById('location-tabs');
    tabs.innerHTML = '';
    selectedLocations.forEach(loc => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `px-4 py-2 rounded-t-lg text-sm font-medium transition-all whitespace-nowrap
            ${currentLocationId === loc.id
                ? 'bg-primary text-white'
                : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'}`;
        btn.textContent = loc.industry_name;
        btn.onclick = () => switchLocation(loc.id);
        tabs.appendChild(btn);
    });
}

function switchLocation(id) {
    currentLocationId = id;

    // Đảm bảo state tồn tại cho location này
    if (!evaluationState[id]) {
        evaluationState[id] = { parents: {} };
    }

    renderLocationTabs();
    renderCriteriaUI();
}

// ==================== RENDER CRITERIA UI ====================
function renderCriteriaUI() {
    const container = document.getElementById('criteria-items-list');
    if (!container) return;
    container.innerHTML = '';

    if (!currentLocationId || !evaluationState[currentLocationId]) return;

    const parents = evaluationState[currentLocationId].parents;

    if (Object.keys(parents).length === 0) {
        container.innerHTML = `
            <div class="text-center py-10 text-gray-400 dark:text-gray-500">
                <span class="material-symbols-outlined text-4xl mb-2 block">playlist_add</span>
                <p class="text-sm">No criteria added. Click <strong>Edit Criteria</strong> to configure.</p>
            </div>`;
        updateTotalWeight();
        return;
    }

    Object.keys(parents).forEach(pId => {
        const parent = parents[pId];
        const parentBlock = document.createElement('div');
        parentBlock.className = "mb-6 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm";
        parentBlock.innerHTML = `
            <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 dark:bg-gray-800/50 px-4 py-3 border-b dark:border-gray-700">
                <div class="col-span-4 font-bold text-primary flex items-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-base">folder</span>
                    ${parent.info?.criteria_name ?? ''}
                </div>
                <div class="col-span-2">
                    <div class="relative">
                        <input type="number" min="0" max="100"
                            value="${parent.weight ?? parent.info?.criteriaPercent ?? ''}"
                            oninput="updateParentWeight('${pId}', this.value)"
                            class="w-full border rounded-lg px-2 pr-6 py-1.5 text-sm dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                            placeholder="0" />
                        <span class="absolute right-2 top-1.5 text-gray-400 text-xs">%</span>
                    </div>
                </div>
                <div class="col-span-4 text-xs text-gray-400 italic">Main criterion weight</div>
            </div>
            <div id="children-of-${pId}" class="divide-y divide-gray-50 dark:divide-gray-700/50 bg-white dark:bg-[#1a2632]"></div>
        `;
        container.appendChild(parentBlock);

        const childContainer = document.getElementById(`children-of-${pId}`);
        const children = parent.children;

        if (Object.keys(children).length === 0) {
            childContainer.innerHTML = `<p class="text-xs text-gray-400 dark:text-gray-500 px-6 py-3 italic">No sub-criteria selected.</p>`;
        } else {
            Object.keys(children).forEach(cId => {
                const child = children[cId];
                const typeId = child.typeId ?? child.info?.criteriaTypeId ?? null;
                let displayUnit = child.info?.type?.name ?? '';
                let valueFieldHTML = '';
                if (typeId == 4) {
                    valueFieldHTML = `
                        <select onchange="handleSpecialType('${pId}', '${cId}', this.value)"
                            class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                            <option value="">Select...</option>
                            <option value="yes" ${child.value === 'yes' ? 'selected' : ''}>Yes</option>
                            <option value="no"  ${child.value === 'no'  ? 'selected' : ''}>No</option>
                        </select>`;
                } else if (typeId == 3) {
                    valueFieldHTML = `
                        <select onchange="handleSpecialType('${pId}', '${cId}', this.value)"
                            class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                            <option value="">Select...</option>
                            <option value="2H4R" ${child.value === '2H4R' ? 'selected' : ''}>2H4R</option>
                            <option value="4H9R" ${child.value === '4H9R' ? 'selected' : ''}>4H9R</option>
                        </select>`;
                } else {
                    valueFieldHTML = `
                        <input type="text" value="${child.value ?? ''}"
                            oninput="updateChildField('${pId}', '${cId}', 'value', this.value)"
                            placeholder="Enter target value..."
                            class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none" />`;
                }

                const row = document.createElement('div');
                row.className = "grid grid-cols-12 gap-4 items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all";
                row.innerHTML = `
                    <div class="col-span-4 text-sm pl-6 flex items-center gap-2 dark:text-gray-300">
                        <span class="text-gray-300 dark:text-gray-600 text-xs">└</span>
                        ${child.info?.criteria_name ?? ''}
                    </div>
                    <div class="col-span-2">
                        <div class="relative">
                            <input type="number" min="0" max="100"
                                value="${child.percentage ?? child.info?.criteriaPercent ?? ''}"
                                oninput="updateChildField('${pId}', '${cId}', 'percentage', this.value)"
                                class="w-full border rounded px-2 pr-5 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                                placeholder="0" />
                            <span class="absolute right-1 top-1 text-gray-400 text-[10px]">%</span>
                        </div>
                    </div>
                    <div class="col-span-2">${valueFieldHTML}</div>
                    <div class="col-span-3">
                        <div class="text-xs text-gray-400 italic">
															${displayUnit ? displayUnit : `no type specified`} 
													</div>
                    </div>
                `;
                childContainer.appendChild(row);
            });
        }
    });

    updateTotalWeight();
}

// ==================== STATE UPDATERS ====================
function updateParentWeight(pId, val) {
    if (evaluationState[currentLocationId]?.parents[pId])
        evaluationState[currentLocationId].parents[pId].weight = val;
    updateTotalWeight();
}

function updateChildField(pId, cId, field, val) {
    const child = evaluationState[currentLocationId]?.parents[pId]?.children[cId];
    if (child) child[field] = val;
}

function handleSpecialType(pId, cId, selectedValue) {
    const child = evaluationState[currentLocationId]?.parents[pId]?.children[cId];
    if (!child) return;
    child.value = selectedValue;

    const basePercent = child.originalPercent
        ?? child.info?.originalPercent
        ?? 0;
        
    if (child.typeId == 4) {
        // yes → 100% của basePercent, no → 0
        child.percentage = selectedValue === 'yes' ? basePercent : 0;
    }

    if (child.typeId == 3) {
        // 4H9R → full basePercent, 2H4R → nửa basePercent
        child.percentage = selectedValue === '4H9R' ? basePercent : Math.round(basePercent / 2);
    }
    renderCriteriaUI();
}

function updateTotalWeight() {
    if (!currentLocationId) return;
    let total = 0;
    Object.values(evaluationState[currentLocationId]?.parents || {})
          .forEach(p => { total += parseFloat(p.weight || 0); });
    document.getElementById('total-weight-display').textContent = total + '%';
    const warn = document.getElementById('total-weight-warning');
    total !== 100 ? warn.classList.remove('hidden') : warn.classList.add('hidden');
}

// ==================== FORM SUBMIT ====================
function submitProjectForm() {
    const form = document.getElementById('project-form');

    const oldInput = form.querySelector('input[name="evaluation_data"]');
    if (oldInput) oldInput.remove();

    // Slim down payload
    const cleanData = {};
    Object.keys(evaluationState).forEach(locId => {
        cleanData[locId] = { parents: {} };
        Object.keys(evaluationState[locId].parents).forEach(pId => {
            const parent = evaluationState[locId].parents[pId];
            cleanData[locId].parents[pId] = {
                id:              parent.info?.id ?? pId,
                criteriaPercent: parent.weight,
                children:        {}
            };
            Object.keys(parent.children).forEach(cId => {
                const child = parent.children[cId];
                cleanData[locId].parents[pId].children[cId] = {
                    id:              child.info?.id ?? cId,
                    criteriaTypeId:  child.typeId ?? child.info?.criteriaTypeId ?? null,
                    parentId:        pId,
                    criteriaPercent: child.percentage,
                    name:            child.info?.criteria_name ?? '',
                    value:           child.value ?? ''
                };
            });
        });
    });

    const input = document.createElement('input');
    input.type  = 'hidden';
    input.name  = 'evaluation_data';
    input.value = JSON.stringify(cleanData);
    form.appendChild(input);

    form.submit();
}
</script>

@endsection