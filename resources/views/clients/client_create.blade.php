@extends('layouts.app')

@section('title', 'Add New Client')

@section('content')
<div class="max-w-[1000px] mx-auto p-6 font-sans text-[#334155]">

  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="flex text-sm text-gray-500 gap-2">
      <li>Dashboard</li>
      <li>/</li>
      <li>Clients</li>
      <li>/</li>
      <li class="font-medium text-blue-600">Add Client</li>
    </ol>
  </nav>

  {{-- Header Section --}}
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Add New Client</h2>
      <p class="text-gray-500 mt-1">
        Enter the details below to register a new client in the system.
      </p>
    </div>

    <div class="flex gap-3 mt-4 md:mt-0">
      <a href="{{ route('clients.screen') }}"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
        Cancel
      </a>
      <button form="clientForm"
        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition">
        Save Client
      </button>
    </div>
  </div>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 px-4 py-3 text-sm">
        {{ $errors->first() }}
      </div>
      @endif
  {{-- Main Form Card --}}
  <form id="clientForm" method="POST" action="{{ route('clients.store') }}"
    class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" enctype="multipart/form-data">
    @csrf

    <div class="p-8 space-y-8">

      {{-- Section 1: Client & Company Information --}}
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">corporate_fare</span>
          <i class="bi bi-building"></i>
          Client & Company Information
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              Client Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="client_name" placeholder="e.g. Acme Corp" required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Company Name <span
                class="text-red-500">*</span></label>
            <input type="text" name="company_name" placeholder="Legal Entity Name" required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      {{-- Section 2: Contact Person Details --}}
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">person</span>
          <i class="bi bi-person"></i>
          Contact Person Details
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Contact Person <span
                class="text-red-500">*</span></label>
            <input type="text" name="client_contact_name" placeholder="Full Name" require
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Contact Person Email <span
                class="text-red-500">*</span></label>
            <input type="email" name="email" placeholder="contact@company.com"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Contact Person Phone <span
                class="text-red-500">*</span></label>
            <input type="text" name="contact_number" placeholder="+1 (555) 000-0000"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

      {{-- Section 3: Location Details --}}
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">location_on</span>
          <i class="bi bi-geo-alt"></i>
          Location Details
        </h5>
        <div class="grid grid-cols-1 gap-6">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Company Address <span
                class="text-red-500">*</span></label>
            <input type="text" name="client_HQ" placeholder="Headquarters Address"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Billing Address <span
                class="text-red-500">*</span></label>
            <input type="text" name="client_billing"
              placeholder="Billing Street Address (if different or input same as above)"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
              <input type="text" name="client_country" placeholder="Country"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="space-y-3">
              <label class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
              <input type="text" name="client_city" placeholder="City"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="space-y-3">
              <label class="block text-sm font-medium text-gray-700">State / Province <span
                  class="text-red-500">*</span></label>
              <input type="text" name="client_state_province" placeholder="State"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <!-- <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Zip / Postal Code <span
                  class="text-red-500">*</span></label>
              <input type="text" name="client_zipcode" placeholder="Zip Code"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div> -->
          </div>
        </div>
      </section>

      <hr class="border-gray-100">

    {{-- Section: Client Logo --}}
    <section>
    <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
        <span class="material-symbols-outlined !text-[20px]">image</span>
        Client Logo
    </h5>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

        {{-- Upload Box --}}
        <label
        for="client_logo"
        class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-xl cursor-pointer
                border-gray-300 bg-gray-50 hover:bg-gray-100 transition group">

        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-blue-500">
            cloud_upload
            </span>
            <p class="mb-2 text-sm text-gray-500">
            <span class="font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-400">PNG, JPG (Max 2MB)</p>
        </div>

        <input
            id="client_logo"
            name="client_logo"
            type="file"
            accept="image/png,image/jpeg"
            class="hidden"
            onchange="previewClientLogo(event)"
        />
        </label>

        {{-- Preview --}}
        <div class="flex items-center justify-center">
        <div class="w-40 h-40 rounded-lg border border-gray-200 flex items-center justify-center bg-white">
            <img
            id="logoPreview"
            src=""
            alt="Client Logo Preview"
            class="hidden w-full h-full object-contain p-2"
            />
            <span id="logoPlaceholder" class="text-sm text-gray-400">
            Logo Preview
            </span>
        </div>
        </div>

    </div>
    </section>

        <hr class="border-gray-100">
      {{-- Section 4: Additional Notes --}}
    <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">description</span>
          <i class="bi bi-journal-text"></i>
          Additional Notes
        </h5>
        <div class="space-y-4">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Internal Notes</label>
            <textarea name="notes" rows="4" placeholder="Enter any specific requirements or notes about this client..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
          </div>

          {{-- Toggle Switch --}}
          <div class="flex items-center gap-3">
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="client_active" class="sr-only peer" checked>
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
              </div>
              <span class="ml-3 text-sm font-medium text-gray-700">Mark Client as Active</span>
            </label>
          </div>
        </div>
      </section>
    </div>

    {{-- Footer --}}
    <div class="bg-gray-50 px-8 py-4 flex justify-end gap-3 border-t border-gray-100">
      <a href="{{ route('clients.screen') }}"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
        Cancel
      </a>
      <button form="clientForm"
        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition">
        Save Client
      </button>
    </div>
  </form>
</div>
<script>
function previewClientLogo(event) {
  const file = event.target.files[0];
  if (!file) return;

  const preview = document.getElementById('logoPreview');
  const placeholder = document.getElementById('logoPlaceholder');

  preview.src = URL.createObjectURL(file);
  preview.classList.remove('hidden');
  placeholder.classList.add('hidden');
}
</script>

@endsection