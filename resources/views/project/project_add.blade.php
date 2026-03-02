@extends('layouts.app')
@section('title','Manage Projects')
@push('styles')
<style>
body { font-family: 'Manrope', sans-serif; }
::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

/* Modal accordion */
.criteria-group { border-radius: 10px; overflow: hidden; border: 1px solid #e5e7eb; margin-bottom: 10px; }
.criteria-group-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; background: #f8fafc; cursor: pointer;
    transition: background 0.15s;
}
.dark .criteria-group-header { background: #1e2d3d; }
.criteria-group-header:hover { background: #f0f4f8; }
.dark .criteria-group-header:hover { background: #253240; }
.criteria-group-header .toggle-icon { transition: transform 0.2s; }
.criteria-group-header.open .toggle-icon { transform: rotate(180deg); }
.criteria-children { display: none; padding: 8px 16px 12px; background: #fff; }
.dark .criteria-children { background: #1a2632; }
.criteria-children.open { display: block; }

/* Checkbox style */
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
        <button type="button" onclick="submitProjectForm()"
          class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold hover:bg-blue-600 shadow-md transition-all">
          <span class="truncate">Save Project</span>
        </button>
      </div>
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
            <input name="project_name" required type="text" placeholder="e.g. Q4 Regional Retail Expansion"
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589]" />
          </label>
          <label class="flex flex-col gap-2 col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Description</span>
            <textarea name="description" rows="4" placeholder="Briefly describe the goals and scope of this project..."
              class="form-textarea w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white p-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589] resize-none"></textarea>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">Start Date</span>
            <input id="start-date" name="start_date" type="date"
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary transition-all" />
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium">End Date</span>
            <input id="end-date" name="end_date" type="date"
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary transition-all" />
          </label>
        </div>
      </div>

      <!-- Section 2: Assignments -->
      <div class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700">
        <h2 class="text-[#111418] dark:text-white text-[22px] font-bold px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">Assignments</h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

          <!-- Clients -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium">Assign Clients</label>
            <div class="relative">
              <div class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary transition-all">
                <span class="material-symbols-outlined text-[#617589] mr-2">search</span>
                <div id="client-tags" class="flex flex-wrap gap-2 flex-1">
                  <input id="client-search" type="text" placeholder="Search clients..."
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
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium">Assign Locations</label>
            <div class="relative">
              <div class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary transition-all">
                <span class="material-symbols-outlined text-[#617589] mr-2">location_on</span>
                <div id="location-tags" class="flex flex-wrap gap-2 flex-1">
                  <input id="location-search" type="text" placeholder="Search locations..."
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

        <!-- Location Tabs (inserted dynamically) -->
        <div id="location-tabs" class="flex gap-2 px-6 pt-4 overflow-x-auto border-b dark:border-gray-700"></div>

        <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          <div>
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold">Evaluation Criteria</h2>
            <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Define the metrics used to evaluate success. Weights must sum to 100%.</p>
          </div>
          <button type="button" onclick="openCriteriaModal()"
            class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-lg transition-colors">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Add Criterion
          </button>
        </div>

        <div class="p-6">
          <!-- Header -->
          <div class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>  
            <div class="col-span-3">Value</div>
            <div class="col-span-2">Type</div>
            <div class="col-span-1 text-center">Action</div>
          </div>

          <!-- Criteria rows rendered here -->
          <div id="criteria-items-list"></div>

        </div>
      </div>

      <!-- Mobile footer spacer -->
      <div class="h-16 md:hidden"></div>
    </form>
  </div>

  <!-- ===================== SINGLE CRITERIA MODAL ===================== -->
  <div id="criteriaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-[#1a2632] rounded-2xl w-full max-w-lg shadow-2xl flex flex-col max-h-[85vh]">

      <!-- Modal Header -->
      <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700 flex-shrink-0">
        <div>
          <h3 class="text-lg font-bold dark:text-white">Add Evaluation Criteria</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Expand a criterion and check the sub-criteria to include.</p>
        </div>
        <button type="button" onclick="closeCriteriaModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <!-- Modal Body: list of parent criteria with expandable children -->
      <div id="modal-criteria-body" class="flex-1 overflow-y-auto p-4 space-y-2"></div>

      <!-- Modal Footer -->
      <div class="px-6 py-4 border-t dark:border-gray-700 flex justify-between items-center flex-shrink-0">
        <span id="modal-selected-count" class="text-sm text-gray-500 dark:text-gray-400"></span>
        <div class="flex gap-2">
          <button type="button" onclick="closeCriteriaModal()" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-white hover:bg-gray-200 text-sm font-medium transition-colors">Cancel</button>
          <button type="button" onclick="applyModalSelections()" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-600 text-sm font-bold transition-colors shadow">Apply</button>
        </div>
      </div>
    </div>
  </div>

</main>

<script>
  // ==================== DATA FROM BLADE ====================
  const allClients   = @json($client);
  const allLocations = @json($locations);
  const criteriaData = @json($criteria); // [{id, criteria_name, description, criteriaPercent, children:[{id, criteria_name,...}]}]

  console.log('Criteria data from backend:', criteriaData);
  let evaluationState  = {};
  let selectedClients  = [];
  let selectedLocations = [];
  let currentLocationId = null;

  // ==================== MODAL ====================
  function openCriteriaModal() {
      if (!currentLocationId) {
          alert('Vui lòng chọn ít nhất một Location trước.');
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

      criteriaData.forEach(parent => {
          const isParentAdded = !!currentParents[parent.id];

          // Group container
          const group = document.createElement('div');
          group.className = 'criteria-group dark:border-gray-700';

          // --- Parent header row ---
          const header = document.createElement('div');
          header.className = 'criteria-group-header';
          header.innerHTML = `
              <div class="flex items-center gap-3 flex-1">
                  <input type="checkbox" class="criteria-cb parent-cb" id="pcb-${parent.id}" data-parent-id="${parent.id}"
                      ${isParentAdded ? 'checked' : ''} />
                  <label for="pcb-${parent.id}" class="font-semibold text-sm dark:text-white cursor-pointer flex-1">
                      ${parent.criteria_name}
                      <span class="ml-2 text-xs text-primary font-normal">${parent.criteriaPercent ?? ''}%</span>
                  </label>
              </div>
              ${parent.children && parent.children.length > 0 ? `
              <span class="material-symbols-outlined toggle-icon text-gray-400 text-base ml-2">expand_more</span>
              ` : ''}
          `;

          // Toggle accordion on header click (but NOT on checkbox click)
          header.addEventListener('click', function(e) {
              if (e.target.type === 'checkbox' || e.target.tagName === 'LABEL') return;
              header.classList.toggle('open');
              childrenEl.classList.toggle('open');
          });

          // Parent checkbox: check/uncheck all children
          const parentCb = header.querySelector('.parent-cb');
          parentCb.addEventListener('change', function() {
              const checked = this.checked;
              group.querySelectorAll('.child-cb').forEach(cb => { cb.checked = checked; });
              updateModalCount();
          });

          group.appendChild(header);

          // --- Children list ---
          const childrenEl = document.createElement('div');
          childrenEl.className = 'criteria-children' + (isParentAdded ? ' open' : '');

          if (parent.children && parent.children.length > 0) {
              parent.children.forEach(child => {
                  const isChildAdded = isParentAdded && !!currentParents[parent.id]?.children[child.id];
                  const row = document.createElement('label');
                  row.className = 'child-checkbox-row flex items-center gap-3';
                  row.innerHTML = `
                      <input type="checkbox" class="criteria-cb child-cb" data-parent-id="${parent.id}" data-child-id="${child.id}"
                          ${isChildAdded ? 'checked' : ''} />
                      <span class="text-sm dark:text-gray-300">${child.criteria_name}</span>
                  `;
                  // Child checkbox change → sync parent checkbox state
                  row.querySelector('.child-cb').addEventListener('change', function() {
                      syncParentCheckbox(parent.id, group);
                      updateModalCount();
                  });
                  childrenEl.appendChild(row);
              });
          } else {
              childrenEl.innerHTML = '<p class="text-xs text-gray-400 py-2">No sub-criteria.</p>';
          }

          // If parent has no children, auto-open isn't needed; still allow checking parent alone
          group.appendChild(childrenEl);
          body.appendChild(group);

          // Open accordion if parent is already added
          if (isParentAdded) header.classList.add('open');
      });

      updateModalCount();
  }

  // Keep parent checkbox in sync with its children
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

  // Apply checkbox selections → update evaluationState → sync all locations
  function applyModalSelections() {
      const body = document.getElementById('modal-criteria-body');
      const newParents = {};

      // Read parent checkboxes
      body.querySelectorAll('.parent-cb').forEach(pcb => {
          const pId = pcb.dataset.parentId;
          const parentInfo = criteriaData.find(c => String(c.id) === String(pId));
          if (!parentInfo) return;

          // If parent checked OR any child checked → include parent
          const childCbs = [...body.querySelectorAll(`.child-cb[data-parent-id="${pId}"]`)];
          const anyChildChecked = childCbs.some(cb => cb.checked);

          if (pcb.checked || anyChildChecked) {
              // Preserve existing weight
              const existingParent = evaluationState[currentLocationId]?.parents[pId];
              newParents[pId] = {
                  info: parentInfo,
                  weight: existingParent?.weight ?? '',
                  children: {}
              };

              // Read child checkboxes
              childCbs.forEach(ccb => {
                  if (ccb.checked) {
                      const cId = ccb.dataset.childId;
                      const childInfo = parentInfo.children.find(c => String(c.id) === String(cId));
                      if (!childInfo) return;
                      const existingChild = existingParent?.children[cId];
                      newParents[pId].children[cId] = {
                          info: childInfo,
                          percentage: existingChild?.percentage ?? childInfo.criteriaPercent ??'',
                          value: existingChild?.value ?? '',
													typeId: childInfo.criteriaTypeId ?? null
                      };
                  }
              });
          }
      });

      // Update current location
      evaluationState[currentLocationId].parents = newParents;

      // Sync structure to all other locations (preserve their own weight/value)
      syncStructureToAllLocations();

      closeCriteriaModal();
      renderCriteriaUI();
  }

  // ==================== SYNC ====================
  function syncStructureToAllLocations() {
      const sourceParents = evaluationState[currentLocationId]?.parents || {};

      selectedLocations.forEach(loc => {
          if (loc.id === currentLocationId) return;
          if (!evaluationState[loc.id]) evaluationState[loc.id] = { parents: {} };

          const targetParents = evaluationState[loc.id].parents;

          // Remove parents no longer in source
          Object.keys(targetParents).forEach(pId => {
              if (!sourceParents[pId]) delete targetParents[pId];
          });

          // Add/update parents from source
          Object.keys(sourceParents).forEach(pId => {
              const srcParent = sourceParents[pId];
              if (!targetParents[pId]) {
                  targetParents[pId] = {
                      info: JSON.parse(JSON.stringify(srcParent.info)),
                      weight: srcParent.weight ?? '',
                      children: {}
                  };
              }
              const targetChildren = targetParents[pId].children;
              const srcChildren    = srcParent.children;

              // Add children from source
              Object.keys(srcChildren).forEach(cId => {
                  if (!targetChildren[cId]) {
                      targetChildren[cId] = {
                          info: JSON.parse(JSON.stringify(srcChildren[cId].info)),
                          percentage: srcChildren[cId].percentage ?? '',
                          value: srcChildren[cId].value ?? '',
                          typeId: srcChildren[cId].typeId ?? srcChildren[cId].info.criteriaTypeId ?? null
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
                      ${parent.info.criteria_name}
                  </div>
                  <div class="col-span-2">
                      <div class="relative">
                          <input type="number" min="0" max="100" value="${parent.weight ?? parent.info.criteriaPercent ?? ''}"
                              oninput="updateParentWeight('${pId}', this.value)"
                              class="w-full border rounded-lg px-2 pr-6 py-1.5 text-sm dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                              placeholder="0" />
                          <span class="absolute right-2 top-1.5 text-gray-400 text-xs">%</span>
                      </div>
                  </div>
                  <div class="col-span-4 text-xs text-gray-400 italic">Main criterion weight</div>
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
                  const child = children[cId];
                  const typeId = child.typeId ?? child.info.criteriaTypeId ?? child.info.type?.id;
									let valueFieldHTML = '';
									let displayUnit = child.info?.type?.name ?? '';
									const showWeightError = (child.typeId == 3 || child.typeId == 4) && child._weightError;
									const weightDisplayVal = child._rawWeight ?? child.percentage ?? child.info.criteriaPercent ?? '';
									if (typeId == 4) { // yes/no
											valueFieldHTML = `
													<select 
															onchange="handleSpecialType('${pId}', '${cId}', this.value)"
															class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
															<option value="">Select...</option>
															<option value="yes" ${child.value === 'yes' ? 'selected' : ''}>Yes</option>
															<option value="no" ${child.value === 'no' ? 'selected' : ''}>No</option>
													</select>
											`;
									}
									else if (typeId == 3) { // 2H4R/4H9R
											valueFieldHTML = `
													<select 
															onchange="handleSpecialType('${pId}', '${cId}', this.value)"
															class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white">
															<option value="">Select...</option>
															<option value="2H4R" ${child.value === '2H4R' ? 'selected' : ''}>2H4R</option>
															<option value="4H9R" ${child.value === '4H9R' ? 'selected' : ''}>4H9R</option>
													</select>
											`;
									}
									else {
											valueFieldHTML = `
													<input type="text" value="${child.value ?? ''}"
                              oninput="updateChildField('${pId}', '${cId}', 'value', this.value)"
                              placeholder="Enter description..."
                              class="w-full border rounded px-2 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none" />
											`;
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
                                  oninput="updateChildField('${pId}', '${cId}', 'percentage', this.value)"
                                  class="w-full border rounded px-2 pr-5 py-1 text-xs dark:bg-[#253240] dark:border-gray-600 dark:text-white focus:ring-1 focus:ring-primary outline-none"
                                  placeholder="0" />
                              <span class="absolute right-1 top-1 text-gray-400 text-[10px]">%</span>
                          </div>
													${showWeightError ? `<p class="text-red-400 text-[10px] mt-1">Nhập weight trước khi chọn.</p>` : ''}
                      </div>
                      <div class="col-span-2">
												${valueFieldHTML}
                      </div>
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

  }

  // ==================== STATE UPDATERS ====================
  function updateParentWeight(pId, val) {
      if (evaluationState[currentLocationId]?.parents[pId])
          evaluationState[currentLocationId].parents[pId].weight = val;
  }

  function updateChildField(pId, cId, field, val) {
      const child = evaluationState[currentLocationId]?.parents[pId]?.children[cId];
      child[field] = val;
			// Nếu user nhập lại weight thì reset lỗi và lưu raw weight để tính lại
			if (field === 'percentage') {
					child._rawWeight = val;
					child._weightError = false;
			}
  }

  function removeParent(pId) {
      selectedLocations.forEach(loc => {
          if (evaluationState[loc.id]?.parents[pId])
              delete evaluationState[loc.id].parents[pId];
      });
      renderCriteriaUI();
  }

	function handleSpecialType(pId, cId, selectedValue) {

    const child = evaluationState[currentLocationId]
        ?.parents[pId]
        ?.children[cId];

    if (!child) return;

    child.value = selectedValue;

		const userWeight = parseFloat(child._rawWeight ?? child.percentage);

    if (!userWeight || isNaN(userWeight)) {
        child._weightError = true;
        renderCriteriaUI();
        return;
    }

    child._weightError = false;

    let percent = 0;

    if (child.typeId == 4) { // yes/no
        percent = selectedValue === 'yes' ? userWeight : 0;
    }

    if (child.typeId == 3) { // 2H4R/4H9R
        percent = selectedValue === '4H9R' ? userWeight : userWeight * 0.6;
    }

    child.percentage = percent;

    renderCriteriaUI();
	}

  // ==================== CLIENT LOGIC ====================
  const clientInput    = document.getElementById('client-search');
  const clientDropdown = document.getElementById('client-dropdown');

  clientInput.addEventListener('input', function() {
      const kw = this.value.toLowerCase().trim();
      if (!kw) { clientDropdown.classList.add('hidden'); return; }
      renderClientDropdown(allClients.filter(c => c.client_name.toLowerCase().includes(kw)));
  });

  document.addEventListener('click', e => {
      if (!clientInput.contains(e.target) && !clientDropdown.contains(e.target))
          clientDropdown.classList.add('hidden');
      if (!locationInput.contains(e.target) && !locationDropdown.contains(e.target))
          locationDropdown.classList.add('hidden');
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
      if (selectedClients.find(c => c.id === client.id)) return;
      selectedClients.push(client);
      const tags = document.getElementById('client-tags');
      const tag  = document.createElement('div');
      tag.className = 'flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded text-xs font-medium';
      tag.innerHTML = `${client.client_name}<button type="button" class="ml-1 hover:text-red-500">✕</button><input type="hidden" name="clients[]" value="${client.id}">`;
      tag.querySelector('button').onclick = () => { selectedClients = selectedClients.filter(c => c.id !== client.id); tag.remove(); };
      tags.insertBefore(tag, clientInput);
      clientInput.value = '';
      clientDropdown.classList.add('hidden');
  }

  // ==================== LOCATION LOGIC ====================
  const locationInput    = document.getElementById('location-search');
  const locationDropdown = document.getElementById('location-dropdown');

  locationInput.addEventListener('input', function() {
      const kw = this.value.toLowerCase().trim();
      if (!kw) { locationDropdown.classList.add('hidden'); return; }
      renderLocationDropdown(allLocations.filter(l => l.industry_name.toLowerCase().includes(kw)));
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

      // Init state, copy structure from current location if exists
      evaluationState[location.id] = { parents: {} };
      if (currentLocationId && evaluationState[currentLocationId]) {
          const src = evaluationState[currentLocationId].parents;
          Object.keys(src).forEach(pId => {
              evaluationState[location.id].parents[pId] = {
                  info: JSON.parse(JSON.stringify(src[pId].info)),
                  weight: '',
                  children: {}
              };
              Object.keys(src[pId].children).forEach(cId => {
                  evaluationState[location.id].parents[pId].children[cId] = {
                      info: JSON.parse(JSON.stringify(src[pId].children[cId].info)),
                      percentage: '',
                      value: '',
											typeId: src[pId].children[cId].typeId ?? src[pId].children[cId].info.criteriaTypeId ?? null
                  };
              });
          });
      }

      selectedLocations.push(location);
      renderLocationTag(location);
      switchLocation(location.id);

      locationInput.value = '';
      locationDropdown.classList.add('hidden');
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
  }

  // ==================== FORM SUBMIT ====================
  function submitProjectForm() {
    const form = document.getElementById('project-form');

    // Slim down evaluationState trước khi gửi
    const cleanData = {};

    Object.keys(evaluationState).forEach(locId => {
        cleanData[locId] = { parents: {} };

        Object.keys(evaluationState[locId].parents).forEach(pId => {
            const parent = evaluationState[locId].parents[pId];

            cleanData[locId].parents[pId] = {
                id:             parent.info.id,
                criteriaPercent: parent.weight,   // % do user nhập
                children:       {}
            };

            Object.keys(parent.children).forEach(cId => {
                const child = parent.children[cId];

                cleanData[locId].parents[pId].children[cId] = {
                    id:              child.info.id,
                    criteriaTypeId:  child.typeId ?? child.info.criteriaTypeId ?? null,
                    parentId:        child.info.parentId,
                    criteriaPercent: child.percentage,  // % do user nhập
                    name:            child.info.criteria_name,
                    value:           child.value ?? ''
                };
            });
        });
    });

    // Xóa input cũ nếu có
    const oldInput = form.querySelector('input[name="evaluation_data"]');
    if (oldInput) oldInput.remove();

    const input = document.createElement('input');
    input.type  = 'hidden';
    input.name  = 'evaluation_data';
    input.value = JSON.stringify(cleanData);
    form.appendChild(input);

    form.submit();
  }
	
  // ==================== DATE VALIDATION ====================
  const startDateInput = document.getElementById('start-date');
  const endDateInput   = document.getElementById('end-date');
  [startDateInput, endDateInput].forEach(el => el.addEventListener('change', validateDates));
  function validateDates() {
      if (startDateInput.value && endDateInput.value && new Date(endDateInput.value) <= new Date(startDateInput.value)) {
          alert('End Date must be later than Start Date');
          endDateInput.value = '';
      }
  }
</script>

@endsection