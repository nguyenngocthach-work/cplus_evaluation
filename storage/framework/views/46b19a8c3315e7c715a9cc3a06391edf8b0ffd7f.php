<?php $__env->startSection('title', 'Manage Criteria'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
  <div class="layout-container flex h-full grow flex-col">
    <main class="flex flex-1 justify-center py-5 px-4 md:px-10 lg:px-40">
      <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">

        
        <div class="flex flex-wrap gap-2 px-4 py-2">
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:underline" href="<?php echo e(route('admin.screen')); ?>">Dashboard</a>
          <span class="text-[#617589] dark:text-gray-400">/</span>
          <span class="text-[#111418] dark:text-white text-sm font-medium">Criteria</span>
        </div>

        
        <div class="flex flex-col md:flex-row justify-between gap-6 p-4 items-start md:items-center">
          <div class="flex min-w-72 flex-col gap-2">
            <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">
              Manage Criteria
            </h1>
            <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">
              View and manage evaluation criteria, weights, and descriptions.
            </p>
          </div>

          <button onclick="openAddModal()" 
            class="flex items-center h-10 px-4 bg-primary text-white rounded-lg shadow-sm hover:bg-blue-600 transition font-bold text-sm">
            <span class="material-symbols-outlined mr-2 !text-lg">add</span>
            Add Criteria
          </button>
        </div>

        
        <div class="flex flex-col md:flex-row justify-between gap-4 px-4 py-4 bg-white dark:bg-[#111a22] rounded-t-xl border-x border-t border-[#dbe0e6] dark:border-gray-700 mt-4">
          <div class="flex flex-1 gap-4 flex-col md:flex-row">
            <form method="GET" action="<?php echo e(route('criteria.screen')); ?>" class="flex flex-1 gap-4">
              <label class="flex flex-col min-w-40 flex-1 max-w-md relative group">
                <span class="material-symbols-outlined absolute left-4 top-3.5 text-[#617589]">search</span>
                <input name="keyword" value="<?php echo e(request('keyword')); ?>"
                  class="form-input flex w-full min-w-0 flex-1 rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] h-12 pl-12 pr-4 text-sm placeholder:text-[#617589] transition-all"
                  placeholder="Search criteria by name..." />
              </label>
              <button type="submit" class="h-12 px-4 rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] text-sm font-bold hover:bg-gray-50 transition-colors">
                Filter
              </button>
            </form>
          </div>
          
          
          <a href="#" class="flex items-center justify-center rounded-lg h-12 bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-600 text-[#111418] dark:text-white hover:bg-gray-50 gap-2 text-sm font-bold px-4 transition-colors">
            <span class="material-symbols-outlined !text-lg">download</span>
            <span class="truncate">Export CSV</span>
          </a>
        </div>

        
        <div class="overflow-x-auto rounded-b-xl border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22]">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-[#f0f2f4] dark:bg-[#1a2632] border-b border-[#dbe0e6] dark:border-gray-700">
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">Criteria</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400 text-center">Weight</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">Description</th>
                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">Actions</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-[#dbe0e6] dark:divide-gray-700">
              <?php $__empty_1 = true; $__currentLoopData = $criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
                  <td class="px-6 py-4">
                    <div class="font-bold text-sm text-[#111418] dark:text-white">
                      <?php echo e($item->criteria_name); ?>

                    </div>
                  </td>

                  <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 px-2.5 py-1 text-xs font-bold border border-blue-100 dark:border-blue-800">
                      <?php echo e($item->criteriaPercent); ?>%
                    </span>
                  </td>

                  <td class="px-6 py-4 text-sm text-[#617589] dark:text-gray-400">
                    <?php echo e($item->description ?? '-'); ?>

                  </td>

                  <td class="px-6 py-4 text-right text-sm">
                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button onclick="openUpdateModal(<?php echo e($item->id); ?>)" class="p-2 text-[#617589] hover:text-primary transition-colors">
                        <span class="material-symbols-outlined !text-lg">edit</span>
                      </button>
                      <button onclick="openUpdateModal(<?php echo e($item->id); ?>, 'view')" class="p-2 text-[#617589] hover:text-[#111418] dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined !text-lg">visibility</span>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                  <td colspan="4" class="text-center py-10 text-gray-500">No criteria found</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div
          class="border flex items-center justify-between border-t border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22] px-4 py-3 sm:px-6 rounded-b-lg mt-1">
          <div class="hidden sm:flex flex-1 sm:items-center sm:justify-between">
            <div class="mt-4 flex justify-end">
              <?php echo e($criteria->withQueryString()->links()); ?>

            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- ADD MODAL -->
<div id="addCriteriaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-[#111a22] rounded-xl p-6 w-[420px]">
    <h3 class="text-lg font-bold mb-4">Add Criteria</h3>

    <form method="POST" action="<?php echo e(route('criteria.store')); ?>">
      <?php echo csrf_field(); ?>

      <label class="block mb-3">
        <span class="text-sm font-medium">Criteria Name</span>
        <input name="criteria_name" required
          class="mt-1 w-full h-11 rounded-lg border px-4 text-sm">
      </label>

      <label class="block mb-3">
        <span class="text-sm font-medium">Weight (%)</span>
        <input name="criteriaPercent" type="number" min="0" max="100" required
          class="mt-1 w-full h-11 rounded-lg border px-4 text-sm">
      </label>

      <label class="block mb-5">
        <span class="text-sm font-medium">Description</span>
        <textarea name="description"
          class="mt-1 w-full rounded-lg border px-4 py-2 text-sm"></textarea>
      </label>

      <div class="flex justify-end gap-3">
        <button type="button" onclick="closeAddModal()"
          class="px-4 py-2 rounded-lg border">Cancel</button>
        <button class="px-4 py-2 rounded-lg bg-primary text-white">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<!-- UPDATE MODAL -->
<div id="updateCriteriaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-[#111a22] rounded-xl p-6 w-[420px]">
    <h3 class="text-lg font-bold mb-4">Edit Criteria</h3>

    <form id="updateCriteriaForm" method="POST">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <label class="block mb-3">
        <span class="text-sm font-medium">Criteria Name</span>
        <input id="u_name" name="criteria_name" required
          class="mt-1 w-full h-11 rounded-lg border px-4 text-sm">
      </label>

      <label class="block mb-3">
        <span class="text-sm font-medium">Weight (%)</span>
        <input id="u_percent" name="criteriaPercent" type="number" min="0" max="100" required
          class="mt-1 w-full h-11 rounded-lg border px-4 text-sm">
      </label>

      <label class="block mb-5">
        <span class="text-sm font-medium">Description</span>
        <textarea id="u_description" name="description"
          class="mt-1 w-full rounded-lg border px-4 py-2 text-sm"></textarea>
      </label>

      <div class="flex justify-end gap-3">
        <button type="button" onclick="closeUpdateModal()"
          class="px-4 py-2 rounded-lg border">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white">
          Update
        </button>
      </div>
    </form>
  </div>
</div>


<script>
const CRITERIA_LIST = <?php echo json_encode($criteria->items(), 15, 512) ?>;

function openAddModal() {
  document.getElementById('addCriteriaModal').classList.remove('hidden');
  document.getElementById('addCriteriaModal').classList.add('flex');
}

function closeAddModal() {
  document.getElementById('addCriteriaModal').classList.add('hidden');
  document.getElementById('addCriteriaModal').classList.remove('flex');
}

function openUpdateModal(id, mode = 'edit') {
  const data = CRITERIA_LIST.find(c => c.id === id);
  if (!data) return alert('Criteria not found');

  const modal = document.getElementById('updateCriteriaModal');
  const form  = document.getElementById('updateCriteriaForm');
  const btn   = form.querySelector('button[type="submit"]');

  form.action = `/criteria/${id}/update`;

  document.getElementById('u_name').value = data.criteria_name;
  document.getElementById('u_percent').value = data.criteriaPercent;
  document.getElementById('u_description').value = data.description ?? '';

  form.querySelectorAll('input, textarea').forEach(i => i.disabled = false);
  btn.classList.remove('hidden');

  if (mode === 'view') {
    //  VIEW MODE
    form.querySelectorAll('input, textarea').forEach(i => i.disabled = true);
    btn.classList.add('hidden'); 
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeUpdateModal() {
  document.getElementById('updateCriteriaModal').classList.add('hidden');
  document.getElementById('updateCriteriaModal').classList.remove('flex');
}
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/criteria/criteria.blade.php ENDPATH**/ ?>