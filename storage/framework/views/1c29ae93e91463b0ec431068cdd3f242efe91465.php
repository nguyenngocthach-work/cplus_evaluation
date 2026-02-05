<?php $__env->startSection('title','Manage Clients'); ?>
<?php $__env->startSection('content'); ?>
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
  <!-- Top Navigation -->
  <div class="layout-container flex h-full grow flex-col">
    <!-- Main Content -->
    <main class="flex flex-1 justify-center py-5 px-4 md:px-10 lg:px-40">
      <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 px-4 py-2">
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:underline"
            href="<?php echo e(route('admin.screen')); ?>">Dashboard</a>
          <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
          <span class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Clients</span>
        </div>
        <!-- Page Heading & Actions -->
        <div class="flex flex-col md:flex-row justify-between gap-6 p-4 items-start md:items-center">
          <div class="flex min-w-72 flex-col gap-2">
            <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Manage
              Clients</h1>
            <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">View and manage your
              client list, contacts, and details.</p>
          </div>
          <a href="<?php echo e(route('clients.create.screen')); ?>"
            class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white hover:bg-blue-600 transition-colors text-sm font-bold leading-normal tracking-[0.015em] shadow-sm">
            <span class="material-symbols-outlined mr-2 !text-lg">add</span>
            <span class="truncate">Add New Client</span>
          </a>
        </div>
        <!-- Toolbar / Filters -->
        <form method="GET" action="<?php echo e(route('clients.screen')); ?>">
          <div
            class="flex flex-col md:flex-row justify-between gap-4 px-4 py-4 bg-white dark:bg-[#111a22] rounded-t-xl border-x border-t border-[#dbe0e6] dark:border-gray-700 mt-4">
            <div class="flex flex-1 gap-4 flex-col md:flex-row">
              <label class="flex flex-col min-w-40 flex-1 max-w-md relative group">
                <span class="material-symbols-outlined absolute left-4 top-3.5 text-[#617589]">search</span>
                <input name="keyword" value="<?php echo e(request('keyword')); ?>"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] focus:border-primary h-12 placeholder:text-[#617589] pl-12 pr-4 text-sm font-normal leading-normal transition-all"
                  placeholder="Search clients by name, email, or ID..." value="" />
              </label>
              <div class="flex gap-2">
                <div class="relative">
                  <select name="client_active"
                    class="h-12 pl-4 pr-10 rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary appearance-none cursor-pointer min-w-[160px]">
                    <option value="">Status: All</option>
                    <option value="1" <?php echo e(request('client_active') === '1' ? 'selected' : ''); ?>>Active</option>
                    <option value="2" <?php echo e(request('client_active') === '2' ? 'selected' : ''); ?>>Pending</option>
                    <option value="0" <?php echo e(request('client_active') === '0' ? 'selected' : ''); ?>>Inactive</option>
                  </select>
                </div>
                <button
                  class="h-12 w-12 flex items-center justify-center rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                  title="More filters">
                  <span class="material-symbols-outlined">tune</span>
                </button>
              </div>
            </div>
            <button type="submit" class="h-12 px-4 rounded-lg border border-[#dbe0e6] dark:border-gray-600
              bg-white dark:bg-[#1a2632] text-sm hover:bg-gray-50 dark:hover:bg-gray-800">
              Filter
            </button>
        </form>
        <a href="<?php echo e(route('clients.export', request()->query())); ?>"
          class="flex items-center justify-center overflow-hidden rounded-lg h-12 bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-600 text-[#111418] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 gap-2 text-sm font-bold leading-normal tracking-[0.015em] px-4 transition-colors">
          <span class="material-symbols-outlined !text-lg">download</span>
          <span class="truncate">Export CSV</span>
        </a>
      </div>
      <!-- Client List Table -->
      <div class="overflow-x-auto rounded-b-xl border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22]">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-[#f0f2f4] dark:bg-[#1a2632] border-b border-[#dbe0e6] dark:border-gray-700">
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Client / Company</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Primary Contact</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Location</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Status</th>
              <th
                class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#dbe0e6] dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
            $name = $client->client_name ?? 'A';
            $initial = strtoupper(substr($name, 0, 1));

            $colors = [
                'bg-red-100 text-red-700',
                'bg-blue-100 text-blue-700',
                'bg-green-100 text-green-700',
                'bg-purple-100 text-purple-700',
                'bg-pink-100 text-pink-700',
                'bg-yellow-100 text-yellow-700',
                'bg-indigo-100 text-indigo-700',
                'bg-teal-100 text-teal-700',
            ];

            $colorClass = $colors[crc32($name) % count($colors)];
            ?>
            <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div
                    class="h-10 w-10 flex-shrink-0 rounded-full flex items-center justify-center <?php echo e($client->logo_img ? '' : $colorClass); ?>">
                    <?php if(!empty($client->logo_img)): ?>
                        <img 
                        src="<?php echo e(Storage::url($client->logo_img)); ?>"
                        alt="<?php echo e($client->client_name); ?>"
                        class="h-full w-full object-cover rounded-full"
                        >
                    <?php else: ?>
                        <span class="font-bold text-lg">
                        <?php echo e($initial); ?>

                        </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    <div class="text-sm font-bold text-[#111418] dark:text-white"><?php echo e($client->client_name); ?></div>
                    <!-- đoạn này đổi thành id "ID: #CL-0024 ở <?php echo e($client->client_id); ?>" -->
                    <div class="text-xs text-[#617589] dark:text-gray-400"><?php echo e($client->company_name); ?></div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-[#111418] dark:text-white"><?php echo e($client->client_contact_name); ?>

                </div>
                <div class="text-xs text-[#617589] dark:text-gray-400"><?php echo e($client->email); ?></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[#111418] dark:text-white"><?php echo e($client->location->client_city ?? ''); ?>,
                  <?php echo e($client->location->client_state_province ?? ''); ?></div>
                <div class="text-xs text-[#617589] dark:text-gray-400"><?php echo e($client->location->client_billing ?? ''); ?>

                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php if($client->client_active == 1): ?>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                  <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                </span>
                <?php else: ?>
                <span
                  class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                  <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span> Inactive
                  <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <a href=" <?php echo e(route('clients.getId', $client)); ?> "
                    class="p-2 text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                    title="Edit">
                    <span class="material-symbols-outlined !text-lg">edit</span>
                  </a>
                  <button type="button" onclick="openDeleteModal(<?php echo e($client->id); ?>)"
                    class="p-2 text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                    title="Delete">
                    <span class="material-symbols-outlined !text-lg">delete</span>
                  </button>
                  <a href=" <?php echo e(route('clients.detail', $client)); ?> "
                    class="p-2 text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white transition-colors"
                    title="View Details">
                    <span class="material-symbols-outlined !text-lg">chevron_right</span>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="text-center py-6 text-gray-500">
                No clients found.
              </td>
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
            <?php echo e($clients->withQueryString()->links()); ?>

          </div>
        </div>
      </div>
  </div>
  </main>
</div>
<div id="deleteClientModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-[#111a22] rounded-xl p-6 w-[420px]">
    <h3 class="text-lg font-bold text-red-600 mb-3">
      Confirm Delete
    </h3>

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
      Are you sure you want to delete this client?
      This action can be undone later.
    </p>

    <div class="flex justify-end gap-3">
      <button onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
        No
      </button>

      <form id="deleteClientForm" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
          Yes, Delete
        </button>
      </form>
    </div>
  </div>
</div>
<script>
function openDeleteModal(clientId) {
  const form = document.getElementById('deleteClientForm');
  form.action = `/clients/${clientId}/delete`;

  const modal = document.getElementById('deleteClientModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteClientModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}
</script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/clients/clients.blade.php ENDPATH**/ ?>