@extends('layouts.app')
@section('title','Manage Projects')
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
    display: flex; align-items: center; gap-10px; padding: 8px 4px;
    border-radius: 6px; cursor: pointer; transition: background 0.12s;
}
.child-checkbox-row:hover { background: #f0f4ff; }
.dark .child-checkbox-row:hover { background: #1e2d3d; }
input[type="checkbox"].criteria-cb {
    width: 16px; height: 16px; accent-color: var(--color-primary, #3b82f6);
    cursor: pointer; flex-shrink: 0;
}

/* input lỗi */
.input-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 1px #ef4444 !important;
}

/* Toast */
#val-toast {
    position: fixed; top: 20px; right: 20px; z-index: 9999;
    background: #fff; border: 1px solid #fecaca; border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,.12); padding: 14px 18px;
    max-width: 360px; display: flex; gap: 12px; align-items: flex-start;
    transform: translateX(120%); transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.dark #val-toast { background: #1e2d3d; border-color: #7f1d1d; }
#val-toast.show { transform: translateX(0); }
#val-toast .toast-icon { color: #ef4444; font-size: 20px; flex-shrink:0; margin-top:1px; }
#val-toast ul { margin: 4px 0 0; padding-left: 16px; font-size: .78rem; color: #dc2626; line-height: 1.6; }
.dark #val-toast ul { color: #f87171; }
#val-toast .toast-title { font-weight: 700; font-size: .85rem; color: #111; }
.dark #val-toast .toast-title { color: #fff; }
#val-toast .toast-close { margin-left:8px; cursor:pointer; color:#9ca3af; flex-shrink:0; font-size:18px; line-height:1; }
#val-toast .toast-close:hover { color:#6b7280; }
</style>
@endpush
@section('content')

<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">

    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors" href="{{route('admin.screen')}}">Dashboard</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors" href="{{route('projects.screen')}}">Projects</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <span class="text-[#111418] dark:text-white text-base font-medium leading-normal">Create New Project</span>
    </div>

    <!-- Page Header -->
    <div class="flex flex-wrap justify-between items-end gap-3 px-4">
      <div class="flex min-w-72 flex-col gap-3">
        <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Create New Project</h1>
        <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">Configure project details, assign stakeholders, and set evaluation metrics.</p>
      </div>
      <div class="flex gap-3">
        <a href="{{route('projects.screen')}}"
          class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-transparent text-[#111418] dark:text-white text-sm font-bold border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
          <span class="truncate">Cancel</span>
        </a>
        <button id="save-project-btn" type="button" onclick="submitProjectForm()"
          class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold hover:bg-blue-600 shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-primary">
          <span class="truncate">Save Project</span>
        </button>
      </div>
      <p id="save-project-reason" class="w-full text-right text-xs text-red-500 mt-1 hidden"></p>
    </div>

    <!-- Main Form -->
    <form id="project-form" method="POST" action="{{ route('projects.store') }}" class="flex flex-col gap-6">
      @csrf

      <!-- Section 1: General Information -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">General Information</h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Project Name <span class="text-red-500">*</span></span>
            <input id="inp-project-name" name="project_name" type="text" placeholder="e.g. Q4 Regional Retail Expansion"
              oninput="clearErr(this)"
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589]" />
          </label>
          <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Note I</span>
            <input type="text" name="notes_1"
                placeholder="Enter note I"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4">
            </label>

            <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Note II</span>
            <input type="text" name="notes_2"
                placeholder="Enter note II"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4">
            </label>

            <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Note III</span>
            <input type="text" name="notes_3"
                placeholder="Enter note III"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4">
            </label>

            <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Note IV</span>
            <input type="text" name="notes_4"
                placeholder="Enter note IV"
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4">
            </label>
        </div>
      </div>

      <!-- Section 2: Assignments -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700">
        <h2 class="text-[#111418] dark:text-white text-[22px] font-bold px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">Assignments</h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

          <!-- Clients -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium">Assign Client <span class="text-red-500">*</span></label>
            <div class="relative">
              <div id="client-box" class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary transition-all">
                <span class="material-symbols-outlined text-[#617589] mr-2">search</span>
                <div id="client-tags" class="flex flex-wrap gap-2 flex-1">
                  <input id="client-search" type="text" placeholder="Search client..."
                    oninput="clearErr(document.getElementById('client-box'))"
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white" />
                </div>
              </div>
              <div id="client-dropdown"
                class="absolute top-full left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg z-40 hidden max-h-48 overflow-y-auto"></div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Select the clients associated with this project.</p>
          </div>

          <!-- Locations -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium">Assign Locations <span class="text-red-500">*</span></label>
            <div class="relative">
              <div id="location-box" class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary transition-all">
                <span class="material-symbols-outlined text-[#617589] mr-2">location_on</span>
                <div id="location-tags" class="flex flex-wrap gap-2 flex-1">
                  <input id="location-search" type="text" placeholder="Search locations..."
                    oninput="clearErr(document.getElementById('location-box'))"
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white" />
                </div>
              </div>
              <div id="location-dropdown"
                class="absolute top-full left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg z-40 hidden max-h-48 overflow-y-auto"></div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Specify where this project will be executed.</p>
          </div>
        </div>
      </div>

      <!-- Section 3: Evaluation Criteria -->
      <div id="evaluation-criteria-list" class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <div id="location-tabs" class="flex gap-2 px-6 pt-4 overflow-x-auto border-b dark:border-gray-700"></div>
        <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          <div>
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold">Evaluation Criteria</h2>
            <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Define the metrics used to evaluate success.</p>
          </div>
          <button type="button" onclick="openCriteriaModal()"
            class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-lg transition-colors">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Add Criterion
          </button>
        </div>
        <div class="p-6">
          <div class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>
            <div class="col-span-3">Value</div>
            <div class="col-span-2">Type</div>
            <div class="col-span-1 text-center">Action</div>
          </div>
          <div id="criteria-items-list"></div>
        </div>
      </div>

      <div class="h-16 md:hidden"></div>
    </form>
  </div>

  <!-- CRITERIA MODAL -->
  <div id="criteriaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-[#1a2632] rounded-2xl w-full max-w-lg shadow-2xl flex flex-col max-h-[85vh]">
      <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700 flex-shrink-0">
        <div>
          <h3 class="text-lg font-bold dark:text-white">Add Evaluation Criteria</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Expand a criterion and check the sub-criteria to include.</p>
        </div>
        <button type="button" onclick="closeCriteriaModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div class="px-6 pt-4">
        <input id="modal-criteria-search" type="text" placeholder="Search main criterion..."
          class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-sm px-3 py-2 dark:text-white focus:ring-2 focus:ring-primary/40 focus:border-primary outline-none transition-all" />
      </div>
      <div id="modal-criteria-body" class="flex-1 overflow-y-auto p-4 space-y-2"></div>
      <div class="px-6 py-4 border-t dark:border-gray-700 flex justify-between items-center flex-shrink-0">
        <span id="modal-selected-count" class="text-sm text-gray-500 dark:text-gray-400"></span>
        <div class="flex gap-2">
          <button type="button" onclick="closeCriteriaModal()" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-white hover:bg-gray-200 text-sm font-medium transition-colors">Cancel</button>
          <button type="button" onclick="applyModalSelections()" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-600 text-sm font-bold transition-colors shadow">Apply</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div id="val-toast">
    <span class="material-symbols-outlined toast-icon">error</span>
    <div class="flex-1">
      <div class="toast-title">Vui lòng kiểm tra lại</div>
      <ul id="val-toast-list"></ul>
    </div>
    <span class="material-symbols-outlined toast-close" onclick="hideToast()">close</span>
  </div>
</main>

<script>
  const allClients              = @json($client);
  const allLocations            = @json($locations);
  const criteriaData            = @json($criteria);
  const defaultCriteriaByLocation = @json($defaultCriteriaByLocation);

  let evaluationState   = {};
  let selectedClients   = [];
  let selectedLocations = [];
  let currentLocationId = null;
  let _toastTimer       = null;
  let modalCriteriaKeyword = '';

  /** Default weight from `criteria.criteriaPercent` (parent or child row in criteriaData). */
  function defaultPercentFromCriteria(info) {
      const v = info?.criteriaPercent;
      if (v === null || v === undefined || v === '') return '';
      const n = Number(v);
      return Number.isFinite(n) ? String(n) : String(v).trim();
  }

  function isBlankWeight(v) {
      return v === '' || v === null || typeof v === 'undefined';
  }

  function autoDistributeDefaultWeightsForLocation(locationId) {
      const parents = evaluationState[locationId]?.parents || {};
      const parentIds = Object.keys(parents);
      if (!parentIds.length) return;

      // Only auto-fill if ALL parent weights are blank — use master criteriaPercent, not even split.
      const allParentBlank = parentIds.every(pId => isBlankWeight(parents[pId].weight));
      if (allParentBlank) {
          parentIds.forEach(pId => {
              parents[pId].weight = defaultPercentFromCriteria(parents[pId].info);
          });
      }

      // For each parent, only auto-fill child % if all blank — use each child's criteriaPercent.
      parentIds.forEach(pId => {
          const childIds = Object.keys(parents[pId].children || {});
          if (!childIds.length) return;
          const allChildBlank = childIds.every(cId => isBlankWeight(parents[pId].children[cId].percentage));
          if (!allChildBlank) return;
          childIds.forEach(cId => {
              const pct = defaultPercentFromCriteria(parents[pId].children[cId].info);
              parents[pId].children[cId].percentage = pct;
              parents[pId].children[cId]._rawWeight = pct;
              parents[pId].children[cId].originalPercent =
                  parseFloat(parents[pId].children[cId].info?.criteriaPercent) || 0;
          });
      });
  }

  function autoDistributeDefaultWeightsForAllLocations() {
      selectedLocations.forEach(loc => autoDistributeDefaultWeightsForLocation(loc.id));
  }

  function collectWeightValidationIssues() {
      const totalIssues = [];
      const childIssues = [];
      const otherIssues = [];
      selectedLocations.forEach(loc => {
          const state = evaluationState[loc.id];
          if (!state) return;
          let parentTotal = 0;
          Object.values(state.parents || {}).forEach(parent => {
              const pName = parent.info?.criteria_name ?? 'Criterion';
              const parentWeight = parseFloat(parent.weight);
              if (isNaN(parentWeight) || parentWeight <= 0) {
                  otherIssues.push(`[${loc.industry_name}] "${pName}" main weight must be > 0%.`);
              } else {
                  parentTotal += parentWeight;
              }

              let childTotal = 0;
              let hasChildErr = false;
              Object.values(parent.children || {}).forEach(child => {
                  const raw = String(child.percentage ?? '').trim();
                  if (raw === '') return; // blank is allowed, treated as 0
                  const w = parseFloat(raw);
                  if (isNaN(w) || w < 0) {
                      hasChildErr = true;
                  } else {
                      childTotal += w;
                  }
              });

              const hasChildren = Object.keys(parent.children || {}).length > 0;
              const rounded = Math.round(childTotal * 100) / 100;
              if (hasChildren && (hasChildErr || rounded !== 100)) {
                  childIssues.push(`[${loc.industry_name}] "${pName}" child total is ${rounded}% (must be 100%).`);
              }
          });

          if (Object.keys(state.parents || {}).length > 0) {
              const roundedParentTotal = Math.round(parentTotal * 100) / 100;
              if (roundedParentTotal !== 100) {
                  totalIssues.push(`[${loc.industry_name}] total main criterion weight is ${roundedParentTotal}% (must be 100%).`);
              }
          }
      });
      return [...totalIssues, ...childIssues, ...otherIssues];
  }

  function refreshSaveButtonState() {
      const btn = document.getElementById('save-project-btn');
      const reasonEl = document.getElementById('save-project-reason');
      if (!btn || !reasonEl) return;

      const reasons = [];
      if (!document.getElementById('inp-project-name')?.value.trim()) reasons.push('Project name is required.');
      if (selectedClients.length === 0) reasons.push('Select at least 1 client.');
      if (selectedLocations.length === 0) reasons.push('Select at least 1 location.');
      reasons.push(...collectWeightValidationIssues());

      const hasInvalid = reasons.length > 0;
      btn.disabled = hasInvalid;
      if (hasInvalid) {
          reasonEl.textContent = reasons[0];
          reasonEl.classList.remove('hidden');
      } else {
          reasonEl.textContent = '';
          reasonEl.classList.add('hidden');
      }
  }

  // ==================== TOAST ====================
  function showToast(errors) {
      const list = document.getElementById('val-toast-list');
      list.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
      const t = document.getElementById('val-toast');
      t.classList.add('show');
      clearTimeout(_toastTimer);
      _toastTimer = setTimeout(hideToast, 6000);
  }
  function hideToast() {
      document.getElementById('val-toast').classList.remove('show');
  }

  // ==================== ERROR HIGHLIGHT ====================
  // Đánh dấu đỏ một input/box, tự xóa khi user nhập
  function markErr(el) {
      if (el) el.classList.add('input-error');
  }
  function clearErr(el) {
      if (el) el.classList.remove('input-error');
  }

  // ==================== VALIDATE ====================
  function validateForm() {
    const errors = [];
    let firstEl  = null;

    // 1. Project name
    const nameEl = document.getElementById('inp-project-name');
    if (!nameEl.value.trim()) {
        markErr(nameEl);
        errors.push('Project name không được để trống.');
        if (!firstEl) firstEl = nameEl;
    }

    // 2. Client
    if (selectedClients.length === 0) {
        const box = document.getElementById('client-box');
        markErr(box);
        errors.push('Chưa chọn client.');
        if (!firstEl) firstEl = document.getElementById('client-search');
    }

    // 3. Location
    if (selectedLocations.length === 0) {
        const box = document.getElementById('location-box');
        markErr(box);
        errors.push('Chưa chọn location.');
        if (!firstEl) firstEl = document.getElementById('location-search');
    }

    // 4. Validate theo từng location
    selectedLocations.forEach(loc => {

        const state = evaluationState[loc.id];
        if (!state) return;

        let parentTotal = 0;
				let hasWeightErr  = false;   // có lỗi weight rỗng/không hợp lệ ở location này không

        Object.keys(state.parents).forEach(pId => {
            const parent = state.parents[pId];
            const pName  = parent.info.criteria_name;
            let childTotal = 0;
            let hasChildWeightErr = false;

            const pwRaw = String(parent.weight ?? '').trim();

            // ===== Parent bắt buộc > 0 =====
            if (pwRaw === '') {
                errors.push(`[${loc.industry_name}] "${pName}": weight không được để trống.`);
								hasWeightErr = true;
            } else {
                const pw = parseFloat(pwRaw);

                if (isNaN(pw) || pw <= 0) {
                    errors.push(`[${loc.industry_name}] "${pName}": weight phải lớn hơn 0.`);
                } else {
                    parentTotal += pw;
                }
            }

            // ===== Child fields =====
            Object.keys(parent.children).forEach(cId => {
                const child = parent.children[cId];
                const cName = child.info.criteria_name;

                const pct = String(child.percentage ?? '').trim();
                const val = String(child.value ?? '').trim();

                if (pct !== '') {
                    const cp = parseFloat(pct);
                    if (isNaN(cp) || cp < 0) {
                        errors.push(`[${loc.industry_name}] "${pName} › ${cName}": weight không hợp lệ.`);
                        hasChildWeightErr = true;
                    } else {
                        childTotal += cp;
                    }
                }

                // Value is optional on create-project.
            });

            // ===== Tổng child mỗi parent phải = 100 =====
            if (!hasChildWeightErr && Object.keys(parent.children).length > 0) {
                const childRounded = Math.round(childTotal * 100) / 100;
                if (childRounded < 100) {
                    errors.push(`[${loc.industry_name}] "${pName}": tổng child weight là ${childRounded}% — còn thiếu ${Math.round((100 - childRounded) * 100) / 100}%.`);
                } else if (childRounded > 100) {
                    errors.push(`[${loc.industry_name}] "${pName}": tổng child weight là ${childRounded}% — vượt ${Math.round((childRounded - 100) * 100) / 100}%.`);
                }
            }

        });

        // ===== Tổng parent phải = 100 =====
					if (!hasWeightErr) {
					const rounded = Math.round(parentTotal * 100) / 100;   // tránh floating-point (99.9999...)
					if (rounded < 100) {
							errors.push(`[${loc.industry_name}] Tổng weight của tiêu chí đang là ${rounded}% — còn thiếu ${Math.round((100 - rounded) * 100) / 100}% để đạt 100%.`);
					} else if (rounded > 100) {
							errors.push(`[${loc.industry_name}] Tổng weight của tiêu chí đang là ${rounded}% — vượt quá ${Math.round((rounded - 100) * 100) / 100}% so với 100%.`);
					}
				}
    });

    const liveIssues = collectWeightValidationIssues();
    liveIssues.forEach(i => {
        if (!errors.includes(i)) errors.push(i);
    });

    if (errors.length > 0) {
        showToast(errors);
        if (firstEl) {
            firstEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => firstEl.focus(), 350);
        }
        return false;
    }

    return true;
  }

  // ==================== MODAL ====================
  function openCriteriaModal() {
      if (!currentLocationId) {
          showToast(['Vui lòng chọn ít nhất một Location trước.']);
          return;
      }
      renderModalBody();
      document.getElementById('criteriaModal').classList.remove('hidden');
      document.getElementById('criteriaModal').classList.add('flex');
  }
  function closeCriteriaModal() {
      document.getElementById('criteriaModal').classList.add('hidden');
      document.getElementById('criteriaModal').classList.remove('flex');
  }

  function renderModalBody() {
      const body = document.getElementById('modal-criteria-body');
      body.innerHTML = '';
      const currentParents = evaluationState[currentLocationId]?.parents || {};
      const keyword = (modalCriteriaKeyword || '').toLowerCase().trim();

      const sortedCriteria = [...criteriaData].sort((a, b) =>
          String(a.criteria_name || '').localeCompare(String(b.criteria_name || ''))
      );

      sortedCriteria.forEach(parent => {
          const parentName = String(parent.criteria_name || '').toLowerCase();
          const hasChildMatch = (parent.children || []).some(ch =>
              String(ch.criteria_name || '').toLowerCase().includes(keyword)
          );
          if (keyword && !parentName.includes(keyword) && !hasChildMatch) return;

          const isParentAdded = !!currentParents[parent.id];
          const group = document.createElement('div');
          group.className = 'criteria-group dark:border-gray-700';

          const header = document.createElement('div');
          header.className = 'criteria-group-header';
          header.innerHTML = `
              <div class="flex items-center gap-3 flex-1">
                  <input type="checkbox" class="criteria-cb parent-cb" id="pcb-${parent.id}" data-parent-id="${parent.id}" ${isParentAdded ? 'checked' : ''} />
                  <label for="pcb-${parent.id}" class="font-semibold text-sm dark:text-white cursor-pointer flex-1">
                      ${parent.criteria_name}
                      <span class="ml-2 text-xs text-primary font-normal">${parent.criteriaPercent ?? ''}%</span>
                  </label>
              </div>
              ${parent.children && parent.children.length > 0 ? `<span class="material-symbols-outlined toggle-icon text-gray-400 text-base ml-2">expand_more</span>` : ''}
          `;
          header.addEventListener('click', function(e) {
              if (e.target.type === 'checkbox' || e.target.tagName === 'LABEL') return;
              header.classList.toggle('open');
              childrenEl.classList.toggle('open');
          });
          const parentCb = header.querySelector('.parent-cb');
          parentCb.addEventListener('change', function() {
              group.querySelectorAll('.child-cb').forEach(cb => { cb.checked = this.checked; });
              updateModalCount();
          });
          group.appendChild(header);

          const childrenEl = document.createElement('div');
          childrenEl.className = 'criteria-children' + (isParentAdded ? ' open' : '');
          if (parent.children && parent.children.length > 0) {
              parent.children.forEach(child => {
                  const isChildAdded = isParentAdded && !!currentParents[parent.id]?.children[child.id];
                  const row = document.createElement('label');
                  row.className = 'child-checkbox-row flex items-center gap-3';
                  row.innerHTML = `
                      <input type="checkbox" class="criteria-cb child-cb" data-parent-id="${parent.id}" data-child-id="${child.id}" ${isChildAdded ? 'checked' : ''} />
                      <span class="text-sm dark:text-gray-300">${child.criteria_name}</span>
                  `;
                  row.querySelector('.child-cb').addEventListener('change', function() {
                      syncParentCheckbox(parent.id, group);
                      updateModalCount();
                  });
                  childrenEl.appendChild(row);
              });
          } else {
              childrenEl.innerHTML = '<p class="text-xs text-gray-400 py-2">No sub-criteria.</p>';
          }
          group.appendChild(childrenEl);
          body.appendChild(group);
          if (isParentAdded) header.classList.add('open');
      });

      if (!body.children.length) {
          body.innerHTML = '<p class="text-sm text-gray-400 dark:text-gray-500 px-2 py-4">No criteria found.</p>';
      }
      updateModalCount();
  }

  function syncParentCheckbox(parentId, groupEl) {
      const childCbs = [...groupEl.querySelectorAll('.child-cb')];
      const parentCb = groupEl.querySelector('.parent-cb');
      if (!childCbs.length) return;
      const allChecked  = childCbs.every(cb => cb.checked);
      const someChecked = childCbs.some(cb => cb.checked);
      parentCb.checked       = allChecked;
      parentCb.indeterminate = !allChecked && someChecked;
  }

  function updateModalCount() {
      const total = document.querySelectorAll('#modal-criteria-body .criteria-cb:checked').length;
      document.getElementById('modal-selected-count').textContent = total > 0 ? `${total} item(s) selected` : '';
  }

  function applyModalSelections() {
      const body = document.getElementById('modal-criteria-body');
      const newParents = {};
      body.querySelectorAll('.parent-cb').forEach(pcb => {
          const pId = pcb.dataset.parentId;
          const parentInfo = criteriaData.find(c => String(c.id) === String(pId));
          if (!parentInfo) return;
          const childCbs = [...body.querySelectorAll(`.child-cb[data-parent-id="${pId}"]`)];
          const anyChildChecked = childCbs.some(cb => cb.checked);
          if (pcb.checked || anyChildChecked) {
              const existingParent = evaluationState[currentLocationId]?.parents[pId];
              newParents[pId] = { info: parentInfo, weight: existingParent?.weight ?? '', children: {} };
              childCbs.forEach(ccb => {
                  if (ccb.checked) {
                      const cId = ccb.dataset.childId;
                      const childInfo = parentInfo.children.find(c => String(c.id) === String(cId));
                      if (!childInfo) return;
                      const existingChild = existingParent?.children[cId];
                      newParents[pId].children[cId] = {
                          info: childInfo,
                          percentage: existingChild?.percentage ?? childInfo.criteriaPercent ?? '',
                          value: existingChild?.value ?? '',
                          typeId: childInfo.criteriaTypeId ?? null,
                          originalPercent: childInfo.criteriaPercent ?? 0,
                          _rawWeight: existingChild?._rawWeight ?? ''
                      };
                  }
              });
          }
      });
      evaluationState[currentLocationId].parents = newParents;
      syncStructureToAllLocations();
      autoDistributeDefaultWeightsForAllLocations();
      closeCriteriaModal();
      renderCriteriaUI();
      refreshSaveButtonState();
  }

  // ==================== SYNC ====================
  function syncStructureToAllLocations() {
      const sourceParents = evaluationState[currentLocationId]?.parents || {};
      selectedLocations.forEach(loc => {
          if (loc.id === currentLocationId) return;
          if (!evaluationState[loc.id]) evaluationState[loc.id] = { parents: {} };
          const targetParents = evaluationState[loc.id].parents;
          Object.keys(targetParents).forEach(pId => { if (!sourceParents[pId]) delete targetParents[pId]; });
          Object.keys(sourceParents).forEach(pId => {
              const srcParent = sourceParents[pId];
              if (!targetParents[pId]) {
                  targetParents[pId] = { info: JSON.parse(JSON.stringify(srcParent.info)), weight: srcParent.weight ?? '', children: {} };
              }
              const targetChildren = targetParents[pId].children;
              Object.keys(srcParent.children).forEach(cId => {
                  if (!targetChildren[cId]) {
                      targetChildren[cId] = {
                          info: JSON.parse(JSON.stringify(srcParent.children[cId].info)),
                          percentage: srcParent.children[cId].percentage ?? '',
                          value: '',
                          typeId: srcParent.children[cId].typeId ?? srcParent.children[cId].info.criteriaTypeId ?? null,
                          originalPercent: srcParent.children[cId].originalPercent ?? srcParent.children[cId].info?.criteriaPercent ?? 0,
                          _rawWeight: srcParent.children[cId]._rawWeight ?? ''
                      };
                  }
              });
          });
      });
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
                  <p class="text-sm">No criteria added yet. Click <strong>Add Criterion</strong> to start.</p>
              </div>`;
          refreshSaveButtonState();
          return;
      }

      const sortedParentIds = Object.keys(parents).sort((a, b) =>
          String(parents[a]?.info?.criteria_name || '').localeCompare(String(parents[b]?.info?.criteria_name || ''))
      );

      sortedParentIds.forEach(pId => {
          const parent = parents[pId];
          const childTotal = Object.values(parent.children || {}).reduce((sum, child) => {
              const v = parseFloat(child?.percentage);
              return sum + (isNaN(v) ? 0 : v);
          }, 0);
          const childRounded = Math.round(childTotal * 100) / 100;
          const childIsInvalid = Object.keys(parent.children || {}).length > 0 && childRounded !== 100;
          const childStatusHtml = Object.keys(parent.children || {}).length > 0
              ? `<span id="child-total-${pId}" class="${childIsInvalid ? 'text-amber-500' : 'text-emerald-600'}">Child total: ${childRounded}% ${childIsInvalid ? '(must be 100%)' : ''}</span>`
              : '<span>No sub-criteria selected</span>';
          const parentBlock = document.createElement('div');
          parentBlock.className = "mb-6 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm";
          parentBlock.innerHTML = `
              <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 dark:bg-gray-800/50 px-4 py-3 border-b dark:border-gray-700">
                  <div class="col-span-4 font-bold text-primary flex items-center gap-2 text-sm">
                      <span class="material-symbols-outlined text-base">folder</span>
                      ${parent.info.criteria_name}
                  </div>
                  <div class="col-span-2">
                      <div class="relative">
                          <input type="number" min="0" max="100" value="${parent.weight ?? parent.info.criteriaPercent ?? ''}"
                              oninput="updateParentWeight('${pId}', this.value); clearErr(this);"
                              class="w-full border rounded-lg px-2 pr-6 py-1.5 text-sm dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                              placeholder="0" />
                          <span class="absolute right-2 top-1.5 text-gray-400 text-xs">%</span>
                      </div>
                  </div>
                  <div class="col-span-4 text-xs text-gray-400 italic">${childStatusHtml}</div>
                  <div class="col-span-2 flex justify-end">
                      <button type="button" onclick="removeParent('${pId}')"
                          class="text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 p-1.5 rounded-md transition-colors">
                          <span class="material-symbols-outlined text-sm">delete</span>
                      </button>
                  </div>
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
                  const child      = children[cId];
                  const typeId     = child.typeId ?? child.info.criteriaTypeId ?? child.info.type?.id;
                  const displayUnit = child.info?.type?.name ?? '';

                  let valueFieldHTML = '';
                  if (typeId == 4) {
                      valueFieldHTML = `
                          <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                              <option value="">Select...</option>
                              <option value="yes" ${child.value === 'yes' ? 'selected' : ''}>Yes</option>
                              <option value="no"  ${child.value === 'no'  ? 'selected' : ''}>No</option>
                          </select>`;
                  } else if (typeId == 7) {
                      valueFieldHTML = `
                          <input type="number" min="0" step="any" value="${child.value ?? ''}"
                              oninput="updateChildField('${pId}', '${cId}', 'value', this.value); clearErr(this);"
                              placeholder="Enter value..."
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none" />`;
                  } else if (typeId == 3) {
                      valueFieldHTML = `
                          <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                              <option value="">Select...</option>
                              <option value="4H9R" ${String(child.value).toUpperCase() === '4H9R' ? 'selected' : ''}>4H9R (100%)</option>
                              <option value="2H4R" ${String(child.value).toUpperCase() === '2H4R' ? 'selected' : ''}>2H4R (50%)</option>
                              <option value="ZERO" ${String(child.value).toUpperCase() === 'ZERO' ? 'selected' : ''}>ZERO (0%)</option>
                          </select>`;
                  } else if (typeId == 6) {
                      const v = String(child.value ?? '').toLowerCase();
                      valueFieldHTML = `
                          <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                              <option value="">Select...</option>
                              <option value="verygood" ${v === 'verygood' ? 'selected' : ''}>Very good (100%)</option>
                              <option value="good" ${v === 'good' ? 'selected' : ''}>Good (70%)</option>
                              <option value="fair" ${v === 'fair' ? 'selected' : ''}>Fair (50%)</option>
                              <option value="poor" ${v === 'poor' ? 'selected' : ''}>Poor (30%)</option>
                              <option value="bad" ${v === 'bad' ? 'selected' : ''}>Bad (0%)</option>
                          </select>`;
                  } else if (typeId == 5) {
                      const cidNum = Number(cId);
                      if (cidNum === 27) {
                          valueFieldHTML = `
                              <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                                  class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                                  <option value="">Select...</option>
                                  <option value="1" ${String(child.value) === '1' ? 'selected' : ''}>Vùng 1 (40%)</option>
                                  <option value="2" ${String(child.value) === '2' ? 'selected' : ''}>Vùng 2 (60%)</option>
                                  <option value="3" ${String(child.value) === '3' ? 'selected' : ''}>Vùng 3 (80%)</option>
                                  <option value="4" ${String(child.value) === '4' ? 'selected' : ''}>Vùng 4 (100%)</option>
                              </select>`;
                      } else if (cidNum === 18) {
                          valueFieldHTML = `
                              <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                                  class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                                  <option value="">Select...</option>
                                  <option value="20" ${String(child.value) === '20' ? 'selected' : ''}>CIT 20% (50%)</option>
                                  <option value="17" ${String(child.value) === '17' ? 'selected' : ''}>CIT 17% (70%)</option>
                                  <option value="15" ${String(child.value) === '15' ? 'selected' : ''}>CIT 15% (80%)</option>
                                  <option value="10" ${String(child.value) === '10' ? 'selected' : ''}>CIT 10% (100%)</option>
                              </select>`;
                      } else {
                          const lv = String(child.value ?? '').toLowerCase();
                          valueFieldHTML = `
                              <select onchange="handleSpecialType('${pId}', '${cId}', this.value); clearErr(this);"
                                  class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
                                  <option value="">Select...</option>
                                  <option value="good" ${lv === 'good' ? 'selected' : ''}>Good</option>
                                  <option value="fair" ${lv === 'fair' ? 'selected' : ''}>Fair</option>
                                  <option value="bad" ${lv === 'bad' ? 'selected' : ''}>Bad</option>
                              </select>`;
                      }
                  } else {
                      valueFieldHTML = `
                          <input type="text" value="${child.value ?? ''}"
                              oninput="updateChildField('${pId}', '${cId}', 'value', this.value); clearErr(this);"
                              placeholder="Enter description..."
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none" />`;
                  }

                  const row = document.createElement('div');
                  row.className = "grid grid-cols-12 gap-4 items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all";
                  row.innerHTML = `
                      <div class="col-span-4 text-sm pl-6 flex items-center gap-2 dark:text-gray-300">
                          <span class="text-gray-300 dark:text-gray-600 text-xs">└</span>
                          ${child.info.criteria_name}
                      </div>
                      <div class="col-span-2">
                          <div class="relative">
                              <input type="number" min="0" max="100" value="${child.percentage ?? child.info.criteriaPercent ?? ''}"
                                  oninput="updateChildField('${pId}', '${cId}', 'percentage', this.value); clearErr(this);"
                                  class="w-full border rounded px-2 pr-5 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                                  placeholder="0" />
                              <span class="absolute right-1 top-1 text-gray-400 text-[10px]">%</span>
                          </div>
                      </div>
                      <div class="col-span-2">${valueFieldHTML}</div>
                      <div class="col-span-3">
                          <div class="text-xs text-gray-400 italic">${displayUnit || 'no type specified'}</div>
                      </div>
                  `;
                  childContainer.appendChild(row);
              });
          }
      });
      refreshSaveButtonState();
  }

  // ==================== STATE UPDATERS ====================
  function syncParentWeightAcrossLocations(pId, val) {
      selectedLocations.forEach(loc => {
          const parent = evaluationState[loc.id]?.parents?.[pId];
          if (parent) parent.weight = val;
      });
  }

  function syncChildWeightAcrossLocations(pId, cId, val) {
      selectedLocations.forEach(loc => {
          const child = evaluationState[loc.id]?.parents?.[pId]?.children?.[cId];
          if (!child) return;
          child.percentage = val;
          child._rawWeight = val;
      });
  }

  function updateParentWeight(pId, val) {
      if (!evaluationState[currentLocationId]?.parents[pId]) return;
      evaluationState[currentLocationId].parents[pId].weight = val;
      syncParentWeightAcrossLocations(pId, val);
      refreshSaveButtonState();
  }

  function refreshChildTotalDisplay(pId) {
      const indicator = document.getElementById(`child-total-${pId}`);
      const parent = evaluationState[currentLocationId]?.parents?.[pId];
      if (!indicator || !parent) return;
      const childTotal = Object.values(parent.children || {}).reduce((sum, child) => {
          const v = parseFloat(child?.percentage);
          return sum + (isNaN(v) ? 0 : v);
      }, 0);
      const rounded = Math.round(childTotal * 100) / 100;
      const invalid = Object.keys(parent.children || {}).length > 0 && rounded !== 100;
      indicator.classList.remove('text-amber-500', 'text-emerald-600');
      indicator.classList.add(invalid ? 'text-amber-500' : 'text-emerald-600');
      indicator.textContent = `Child total: ${rounded}% ${invalid ? '(must be 100%)' : ''}`;
  }

  function updateChildField(pId, cId, field, val) {
      const child = evaluationState[currentLocationId]?.parents[pId]?.children[cId];
      if (!child) return;
      child[field] = val;
      if (field === 'percentage') {
          child._rawWeight = val;
          syncChildWeightAcrossLocations(pId, cId, val);
          refreshChildTotalDisplay(pId);
      }
      refreshSaveButtonState();
  }

  function removeParent(pId) {
      selectedLocations.forEach(loc => {
          if (evaluationState[loc.id]?.parents[pId]) delete evaluationState[loc.id].parents[pId];
      });
      renderCriteriaUI();
      refreshSaveButtonState();
  }

  function handleSpecialType(pId, cId, selectedValue) {
      const child = evaluationState[currentLocationId]?.parents?.[pId]?.children?.[cId];
      if (!child) return;
      child.value = selectedValue;

      renderCriteriaUI();
      refreshChildTotalDisplay(pId);
      refreshSaveButtonState();
  }

  // ==================== CLIENT LOGIC ====================
  const clientInput    = document.getElementById('client-search');
  const clientDropdown = document.getElementById('client-dropdown');

  clientInput.addEventListener('focus', () => renderClientDropdown(allClients));
  clientInput.addEventListener('input', function() {
      const kw = this.value.toLowerCase().trim();
      renderClientDropdown(!kw ? allClients : allClients.filter(c => c.client_name.toLowerCase().includes(kw)));
  });

  document.addEventListener('click', e => {
      if (!clientInput.contains(e.target) && !clientDropdown.contains(e.target))
          clientDropdown.classList.add('hidden');
      if (!locationInput.contains(e.target) && !locationDropdown.contains(e.target))
          locationDropdown.classList.add('hidden');
  });
  document.getElementById('inp-project-name')?.addEventListener('input', refreshSaveButtonState);
  document.getElementById('modal-criteria-search')?.addEventListener('input', function() {
      modalCriteriaKeyword = this.value || '';
      renderModalBody();
  });

  function renderClientDropdown(list) {
      clientDropdown.innerHTML = '';
      list.forEach(c => {
          const d = document.createElement('div');
          d.className = 'px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-white';
          d.textContent = c.client_name;
          d.onclick = () => addClient(c);
          clientDropdown.appendChild(d);
      });
      clientDropdown.classList.remove('hidden');
  }

  function addClient(client) {
      const tags = document.getElementById('client-tags');
      const oldTag = tags.querySelector('.client-tag');
      if (oldTag) oldTag.remove();
      selectedClients = [client];
      clearErr(document.getElementById('client-box'));

      const tag = document.createElement('div');
      tag.className = 'client-tag flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded text-xs font-medium';
      tag.innerHTML = `${client.client_name}
          <button type="button" class="ml-1 hover:text-red-500">✕</button>
          <input type="hidden" name="client_id" value="${client.id}">`;
      tag.querySelector('button').onclick = () => {
          selectedClients = [];
          tag.remove();
          refreshSaveButtonState();
      };
      tags.insertBefore(tag, clientInput);
      clientInput.value = '';
      clientDropdown.classList.add('hidden');
      refreshSaveButtonState();
  }

  // ==================== LOCATION LOGIC ====================
  const locationInput    = document.getElementById('location-search');
  const locationDropdown = document.getElementById('location-dropdown');

  locationInput.addEventListener('focus', () => renderLocationDropdown(allLocations));
  locationInput.addEventListener('input', function() {
      const kw = this.value.toLowerCase().trim();
      renderLocationDropdown(!kw ? allLocations : allLocations.filter(l => l.industry_name.toLowerCase().includes(kw)));
  });

  function renderLocationDropdown(list) {
      locationDropdown.innerHTML = '';
      list.forEach(loc => {
          const d = document.createElement('div');
          d.className = 'px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-white';
          d.textContent = loc.industry_name;
          d.onclick = () => addLocation(loc);
          locationDropdown.appendChild(d);
      });
      locationDropdown.classList.remove('hidden');
  }

  function addLocation(location) {
      if (selectedLocations.find(l => l.id === location.id)) return;
      clearErr(document.getElementById('location-box'));

      evaluationState[location.id] = { parents: {} };
      const defaults = defaultCriteriaByLocation[location.id];

      if (defaults && Object.keys(defaults).length > 0) {
          Object.keys(defaults).forEach(pId => {
              const def = defaults[pId];
              const parentInfo = criteriaData.find(c => String(c.id) === String(pId));
              if (!parentInfo) return;
              evaluationState[location.id].parents[pId] = { info: parentInfo, weight: def.weight ?? '', children: {} };
              Object.keys(def.children).forEach(cId => {
                  const dc = def.children[cId];
                  const childInfo = (parentInfo.children ?? []).find(c => String(c.id) === String(cId));
                  if (!childInfo) return;
                  evaluationState[location.id].parents[pId].children[cId] = {
                      info: childInfo, percentage: dc.weight ?? '', value: dc.value ?? '',
                      typeId: dc.typeId ?? childInfo.criteriaTypeId ?? null,
                      originalPercent: childInfo.criteriaPercent ?? 0
                  };
              });
          });
      } else if (currentLocationId && evaluationState[currentLocationId]) {
          const src = evaluationState[currentLocationId].parents;
          Object.keys(src).forEach(pId => {
              evaluationState[location.id].parents[pId] = {
                  info: JSON.parse(JSON.stringify(src[pId].info)), weight: '', children: {}
              };
              Object.keys(src[pId].children).forEach(cId => {
                  evaluationState[location.id].parents[pId].children[cId] = {
                      info: JSON.parse(JSON.stringify(src[pId].children[cId].info)),
                      percentage: '', value: '',
                      typeId: src[pId].children[cId].typeId ?? src[pId].children[cId].info.criteriaTypeId ?? null,
                      originalPercent: src[pId].children[cId].originalPercent ?? src[pId].children[cId].info?.criteriaPercent ?? 0
                  };
              });
          });
      }

      autoDistributeDefaultWeightsForLocation(location.id);

      selectedLocations.push(location);
      renderLocationTag(location);
      switchLocation(location.id);
      locationInput.value = '';
      locationDropdown.classList.add('hidden');
      refreshSaveButtonState();
  }

  function renderLocationTag(location) {
      const tags = document.getElementById('location-tags');
      const tag  = document.createElement('div');
      tag.className = 'flex items-center gap-1 bg-green-500/10 text-green-600 px-2 py-1 rounded text-xs font-medium';
      tag.id = `loc-tag-${location.id}`;
      tag.innerHTML = `${location.industry_name}<button type="button" class="ml-1 hover:text-red-500">✕</button><input type="hidden" name="locations[]" value="${location.id}">`;
      tag.querySelector('button').onclick = () => {
          selectedLocations = selectedLocations.filter(l => l.id !== location.id);
          delete evaluationState[location.id];
          tag.remove();
          if (currentLocationId === location.id)
              currentLocationId = selectedLocations.length > 0 ? selectedLocations[0].id : null;
          renderLocationTabs();
          renderCriteriaUI();
          refreshSaveButtonState();
      };
      tags.insertBefore(tag, locationInput);
  }

  function renderLocationTabs() {
      const tabs = document.getElementById('location-tabs');
      tabs.innerHTML = '';
      selectedLocations.forEach(loc => {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = `px-4 py-2 rounded-t-lg text-sm font-medium transition-all whitespace-nowrap
              ${currentLocationId === loc.id ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'}`;
          btn.textContent = loc.industry_name;
          btn.onclick = () => switchLocation(loc.id);
          tabs.appendChild(btn);
      });
  }

  function switchLocation(id) {
      currentLocationId = id;
      renderLocationTabs();
      renderCriteriaUI();
      refreshSaveButtonState();
  }

  // ==================== FORM SUBMIT ====================
  function submitProjectForm() {
      if (!validateForm()) return; // block nếu có lỗi

      const form = document.getElementById('project-form');
      const cleanData = {};

      Object.keys(evaluationState).forEach(locId => {
          cleanData[locId] = { parents: {} };
          Object.keys(evaluationState[locId].parents).forEach(pId => {
              const parent = evaluationState[locId].parents[pId];
              cleanData[locId].parents[pId] = { id: parent.info.id, criteriaPercent: parent.weight, children: {} };
              Object.keys(parent.children).forEach(cId => {
                  const child = parent.children[cId];
                  cleanData[locId].parents[pId].children[cId] = {
                      id: child.info.id,
                      criteriaTypeId: child.info?.criteriaTypeId ?? child.typeId ?? null,
                      parentId: child.info.parentId,
                      criteriaPercent: child.percentage,
                      name: child.info.criteria_name,
                      value: child.value ?? ''
                  };
              });
          });
      });

      const oldInput = form.querySelector('input[name="evaluation_data"]');
      if (oldInput) oldInput.remove();
      const input = document.createElement('input');
      input.type  = 'hidden';
      input.name  = 'evaluation_data';
      input.value = JSON.stringify(cleanData);
      form.appendChild(input);
      form.submit();
  }

  refreshSaveButtonState();
</script>

@endsection