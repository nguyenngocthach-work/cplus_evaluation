<?php $__env->startSection('title', 'Client Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1000px] mx-auto p-6 font-sans text-[#334155]">

  
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="flex text-sm text-gray-500 gap-2">
      <li>Dashboard</li>
      <li>/</li>
      <li>Clients</li>
      <li>/</li>
      <li class="font-medium text-blue-600">Client Details</li>
    </ol>
  </nav>

  
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">
        <?php echo e($client->client_name); ?>

      </h2>
      <p class="text-gray-500 mt-1">
        Client & company information overview
      </p>
    </div>

    <div class="flex gap-3 mt-4 md:mt-0">
      <a href="<?php echo e(route('clients.screen')); ?>"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
        Back
      </a>
      <a href="<?php echo e(route('clients.getId', $client)); ?>"
        class="px-4 py-2 bg-blue-600 rounded-md text-sm font-medium text-white hover:bg-blue-700">
        Edit Client
      </a>
    </div>
  </div>

  
  <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

    <div class="p-8 space-y-10">

      
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">corporate_fare</span>
          Client & Company Information
        </h5>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <p class="text-sm text-gray-500">Client Name</p>
            <p class="font-medium text-slate-800"><?php echo e($client->client_name); ?></p>
          </div>

          <div>
            <p class="text-sm text-gray-500">Company Name</p>
            <p class="font-medium text-slate-800"><?php echo e($client->company_name); ?></p>
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">person</span>
          Contact Person Details
        </h5>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <p class="text-sm text-gray-500">Contact Person</p>
            <p class="font-medium"><?php echo e($client->client_contact_name); ?></p>
          </div>

          <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-medium"><?php echo e($client->email); ?></p>
          </div>

          <div>
            <p class="text-sm text-gray-500">Phone</p>
            <p class="font-medium"><?php echo e($client->contact_number); ?></p>
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">location_on</span>
          Location Details
        </h5>

        <div class="space-y-4">
          <div>
            <p class="text-sm text-gray-500">Headquarters Address</p>
            <p class="font-medium"><?php echo e(optional($client->location)->client_HQ); ?></p>
          </div>

          <div>
            <p class="text-sm text-gray-500">Billing Address</p>
            <p class="font-medium"><?php echo e(optional($client->location)->client_billing); ?></p>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
              <p class="text-sm text-gray-500">Country</p>
              <p class="font-medium"><?php echo e(optional($client->location)->client_country); ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">City</p>
              <p class="font-medium"><?php echo e(optional($client->location)->client_city); ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">State</p>
              <p class="font-medium"><?php echo e(optional($client->location)->client_state_province); ?></p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Zip Code</p>
              <p class="font-medium"><?php echo e(optional($client->location)->client_zipcode); ?></p>
            </div>
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">image</span>
          Client Logo
        </h5>

        <div class="flex items-center gap-6">
          <div class="w-40 h-40 rounded-lg border bg-gray-50 flex items-center justify-center">
            <?php if($client->logo_img): ?>
              <img
                src="<?php echo e(asset('storage/' . $client->logo_img)); ?>"
                alt="Client Logo"
                class="w-full h-full object-contain p-4"
              />
            <?php else: ?>
              <span class="text-sm text-gray-400">No Logo</span>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">description</span>
          Additional Information
        </h5>

        <div class="space-y-4">
          <div>
            <p class="text-sm text-gray-500">Internal Notes</p>
            <p class="text-slate-700 whitespace-pre-line">
              <?php echo e($client->notes ?? '—'); ?>

            </p>
          </div>

          <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Status</span>
            <?php if($client->client_active): ?>
              <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                Active
              </span>
            <?php else: ?>
              <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-600">
                Inactive
              </span>
            <?php endif; ?>
          </div>
        </div>
      </section>

    </div>

    
    <div class="bg-gray-50 px-8 py-4 flex justify-end gap-3 border-t">
      <a href="<?php echo e(route('clients.screen')); ?>"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm bg-white hover:bg-gray-50">
        Back
      </a>
      <a href="<?php echo e(route('clients.getId', $client)); ?>"
        class="px-4 py-2 bg-blue-600 rounded-md text-sm text-white hover:bg-blue-700">
        Edit Client
      </a>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/clients/client_detail.blade.php ENDPATH**/ ?>