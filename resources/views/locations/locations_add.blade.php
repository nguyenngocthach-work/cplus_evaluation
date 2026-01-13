@extends('layouts.app')

@section('title', 'Add New Location')

@section('content')
<div class="max-w-[1000px] mx-auto p-6 font-sans text-[#334155]">

  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="flex text-sm text-gray-500 gap-2">
      <li>Dashboard</li>
      <li>/</li>
      <li>Location</li>
      <li>/</li>
      <li class="font-medium text-blue-600">Add Location</li>
    </ol>
  </nav>

  {{-- Header Section --}}
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div>
      <h2 class="text-3xl font-bold text-slate-800">Add New Location</h2>
      <p class="text-gray-500 mt-1">
        Enter the details below to register a new location in the system.
      </p>
    </div>

    <div class="flex gap-3 mt-4 md:mt-0">
      <a href="{{ route('locations.screen') }}"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
        Cancel
      </a>
      <button form="clientForm"
        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition">
        Save Location
      </button>
    </div>
  </div>

  {{-- Main Form Card --}}
  <form id="clientForm" method="POST" action="{{ route('locations.store') }}" enctype="multipart/form-data"
    class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    @csrf

    <div class="p-8 space-y-8">

      {{-- Section 1: Client & Company Information --}}
      <section>
        <h5 class="flex items-center gap-2 text-blue-600 font-semibold mb-6">
          <span class="material-symbols-outlined !text-[20px]">location_home</span>
          <i class="bi bi-building"></i>
          Location Name
        </h5>
        <div class="grid grid-cols-1 gap-6">
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">
              Location Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="industry_name" placeholder="industrial center,...etc,..." required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4"
              placeholder="Enter any specific requirements or notes about this location..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
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
            <label class="block text-sm font-medium text-gray-700">Street Address <span
                class="text-red-500">*</span></label>
            <input type="text" name="street" placeholder="Location Address"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          </div>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
              <input type="text" name="country" placeholder="Country"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
              <input type="text" name="city" placeholder="City"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">State / Province <span
                  class="text-red-500">*</span></label>
              <input type="text" name="state_province" placeholder="State"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Zip / Postal Code <span
                  class="text-red-500">*</span></label>
              <input type="text" name="zipcode" placeholder="Zip Code"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
          </div>
        </div>
      </section>

      <hr class="border-gray-100">
      <section>
        <h3 class="text-lg font-bold text-[#111418] dark:text-white mb-6 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">perm_media</span>
          Site Photos
        </h3>
        @if ($errors->has('photos.*') || $errors->has('photos'))
        <div class="text-red-500 text-xs mb-4">
          @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
          @endforeach
        </div>
        @endif
        <input type="file" name="photos[]" id="photoInput" multiple accept="image/png,image/jpeg" class="hidden" />
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          <!-- Existing Photo -->
          <div id="photoPreview" class="contents"></div>
          <!-- Upload New -->
          <div onclick="document.getElementById('photoInput').click()"
            class="aspect-square rounded-lg border-2 border-dashed border-[#e5e7eb] dark:border-slate-700 bg-[#f9fafb] dark:bg-slate-800/50 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors group text-[#617589] hover:text-primary">
            <span
              class="material-symbols-outlined text-3xl mb-2 group-hover:scale-110 transition-transform">cloud_upload</span>
            <span class="text-xs font-bold">Upload Photo</span>
          </div>
        </div>
        <p class="text-xs text-[#617589] dark:text-slate-500">Supported formats: JPG, PNG. Max size: 5MB.</p>
      </section>
      <hr class="border-gray-100">
    </div>

    {{-- Footer --}}
    <div class="bg-gray-50 px-8 py-4 flex justify-end gap-3 border-t border-gray-100">
      <a href="{{ route('locations.screen') }}"
        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
        Cancel
      </a>
      <button form="clientForm"
        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition">
        Save Location
      </button>
    </div>
  </form>
</div>
<script>
const input = document.getElementById('photoInput');
const preview = document.getElementById('photoPreview');
let selectedFiles = [];
const MAX_FILES = 7;
const MAX_SIZE_MB = 5;

input.addEventListener('change', (e) => {
  // Lấy các file mới chọn
  const newFiles = Array.from(input.files);

  newFiles.forEach(file => {
    // Kiểm tra giới hạn 7 ảnh
    if (selectedFiles.length >= MAX_FILES) return;

    // Kiểm tra dung lượng 5MB
    if (file.size > MAX_SIZE_MB * 1024 * 1024) {
      alert(`File ${file.name} quá lớn!`);
      return;
    }

    // Kiểm tra định dạng (Double check ở Client)
    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
      alert(`File ${file.name} không đúng định dạng!`);
      return;
    }

    selectedFiles.push(file);
  });

  syncAndRender();
});

function syncAndRender() {
  // Cập nhật lại thuộc tính files của input để gửi lên server
  const dt = new DataTransfer();
  selectedFiles.forEach(file => dt.items.add(file));
  input.files = dt.files;

  // Vẽ lại giao diện
  preview.innerHTML = '';
  selectedFiles.forEach((file, index) => {
    const url = URL.createObjectURL(file);
    const item = document.createElement('div');
    item.className = 'relative aspect-square group rounded-lg overflow-hidden cursor-pointer';
    item.innerHTML = `
            <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
                style="background-image:url('${url}')"></div>
            <div onclick="event.stopPropagation(); removeImage(${index})"
                class="absolute top-2 right-2 p-1 bg-black/50 rounded-full text-white
                        opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500 z-10">
                <span class="material-symbols-outlined text-sm block">close</span>
            </div>
        `;
    preview.appendChild(item);
  });
}

function removeImage(index) {
  selectedFiles.splice(index, 1);
  syncAndRender();
}
</script>

@endsection