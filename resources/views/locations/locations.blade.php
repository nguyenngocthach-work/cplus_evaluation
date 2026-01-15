@extends('layouts.app')
@section('title','Manage Locations')
@push('styles')
<style>
/* Custom scrollbar for better aesthetics in the sidebar */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 20px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #475569;
}

.form-input-styled {
  @apply w-full rounded-lg border-none bg-[#f0f2f4] dark: bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50;
}

.form-input-styled[readonly] {
  @apply opacity-75 cursor-not-allowed bg-gray-100 dark: bg-slate-850;
}

.location-item.active {
  background-color: rgba(59, 130, 246, 0.1);
  /* primary/10 */
  border: 1px solid rgba(59, 130, 246, 0.2);
}
</style>
@endpush
@section('content')
<div class="relative flex h-screen w-full flex-col overflow-hidden">
  <!-- Main Layout -->
  <div class="flex flex-1 overflow-hidden">
    <!-- Left Sidebar (List View) -->
    <aside
      class="flex w-full lg:w-[380px] flex-col border-r border-[#f0f2f4] dark:border-slate-800 bg-white dark:bg-slate-900 z-10">
      <!-- Sidebar Header -->
      <div class="p-4 border-b border-[#f0f2f4] dark:border-slate-800">
        <h2 class="text-2xl font-bold leading-tight tracking-tight mb-4">Locations</h2>
        <!-- Search Bar -->
        <label class="flex flex-col w-full h-11">
          <div
            class="flex w-full flex-1 items-stretch rounded-lg h-full bg-[#f0f2f4] dark:bg-slate-800 transition-colors">
            <div class="text-[#617589] dark:text-slate-400 flex items-center justify-center pl-4 rounded-l-lg">
              <span class="material-symbols-outlined text-[20px]">search</span>
            </div>
            <input
              class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg bg-transparent text-[#111418] dark:text-white focus:outline-0 focus:ring-0 border-none h-full placeholder:text-[#617589] dark:placeholder:text-slate-500 px-3 text-sm font-normal leading-normal"
              placeholder="Search locations..." value="" />
          </div>
        </label>
      </div>
      <!-- List Items -->
      <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1">
        @foreach($locations as $location)
        <!-- Active Item -->
        <div onclick="selectLocation(this)" data-json='@json($location)'
          class="location-item flex items-center gap-3 px-3 py-3 rounded-lg border-primary/20 cursor-pointer transition-all">
          @php
          $thumbnail = $location->photos->first()
          ? asset('storage/' . $location->photos->first()->img_url)
          : asset('images/no-image.png');
          @endphp
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Exterior view of a modern warehouse building" style='background-image: url("{{ $thumbnail }}");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p class="text-[#111418] dark:text-white text-sm font-bold leading-normal line-clamp-1">
              {{ $location->industry_name}}
            </p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">
              {{$location->street}},
              {{$location->city}}</p>
          </div>
          <span class="material-symbols-outlined text-primary text-xl">arrow_forward_ios</span>

        </div>
        @endforeach
      </div>
      <!-- Sidebar Footer -->
      <div class="p-4 border-t border-[#f0f2f4] dark:border-slate-800">
        <a href="{{route('locations.create.screen')}}"
          class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary hover:bg-blue-600 text-white text-sm font-bold leading-normal tracking-[0.015em] transition-colors shadow-sm">
          <span class="material-symbols-outlined mr-2 text-lg">add</span>
          <span class="truncate">Add New Location</span>
        </a>
      </div>
    </aside>
    <!-- Right Content Area (Detail View) -->
    <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:p-10">
      <div id="emptyState" class="h-full flex flex-col items-center justify-center text-[#617589]">
        <span class="material-symbols-outlined text-6xl mb-4">map</span>
        <p>Chọn một địa điểm từ danh sách để xem chi tiết</p>
      </div>
      <div id="detailWrapper" class="hidden max-w-[960px] mx-auto flex flex-col gap-6">
        <!-- Page Header for specific item -->
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="flex items-center gap-3">
              <h1 class="text-[#111418] dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">Central
                Warehouse</h1>
              <span
                class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide">Active</span>
            </div>
            <p class="text-[#617589] dark:text-slate-400 text-base font-normal mt-1">Manage details, geographic data,
              and media for this site.</p>
          </div>
          <form id="locationForm" action="" method="POST" class="hidden" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex gap-3">
              <button type="button" id="btn-edit" onclick="toggleEdit(true)" class=" flex h-10 items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-slate-700
              bg-white dark:bg-slate-800 px-4 text-sm font-bold text-[#111418] dark:text-white hover:bg-slate-50
              dark:hover:bg-slate-700 transition-colors">
                Edit
              </button>
              <button type="button" id="btn-cancel" onclick="toggleEdit(false)"
                class="hidden flex h-10 items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm font-bold text-[#111418] dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                Cancel
              </button>
              <button type="submit" id="btn-save"
                class="hidden flex h-10 items-center justify-center rounded-lg bg-primary px-6 text-sm font-bold text-white hover:bg-blue-600 shadow-sm transition-colors">
                Save Changes
              </button>
            </div>

        </div>
        <!-- Form Content -->
        <input type="hidden" name="id" id="field-id">
        <div class="flex flex-col gap-8">
          <!-- Section 1: Basic Information -->
          <div
            class="rounded-xl border border-[#e5e7eb] dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#111418] dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">info</span>
              Basic Information
            </h3>
            <div class="grid grid-cols-1 gap-6">
              <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Location Name</label>
                <input id="field-name" name="industry_name" readonly
                  class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50 placeholder:text-[#617589]"
                  type="text" value=" " />
              </div>
              <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Description</label>
                <textarea id="field-description" name="description" readonly
                  class="w-full resize-none rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50 placeholder:text-[#617589]"
                  rows="3" type="text"></textarea>
              </div>
            </div>
          </div>
          <!-- Section 2: Geography & Map -->
          <div
            class="rounded-xl border border-[#e5e7eb] dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#111418] dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">location_on</span>
              Location &amp; Geography
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-2">
                  <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Street Address</label>
                  <input id="field-street" name="street" readonly
                    class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                    type="text" value="" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">City</label>
                    <input id="field-city" name="city" readonly
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="" />
                  </div>
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">State / Province</label>
                    <input id="field-state" name="state_province" readonly
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="" />
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Zip Code</label>
                    <input id="field-zip" name="zipcode" readonly
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="" />
                  </div>
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Country</label>
                    <input id="field-country" name="country" readonly
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50">
                    </input>
                  </div>
                </div>
              </div>
              <!-- Map Widget Placeholder -->
              <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Pin Location</label>
                <div
                  class="relative w-full h-full min-h-[240px] rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 group border border-transparent hover:border-primary/50 transition-colors">
                  <div id="map-background"
                    class="absolute inset-0 bg-cover bg-center opacity-80 group-hover:opacity-100 transition-opacity"
                    style='background-image: url("https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1000&auto=format&fit=crop");'>
                  </div>

                  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                    <span class="material-symbols-outlined text-4xl text-red-600 drop-shadow-md">location_on</span>
                    <div id="map-label"
                      class="bg-white dark:bg-slate-900 text-xs font-bold px-2 py-1 rounded shadow-md mt-1 whitespace-nowrap">
                      Loading City...
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- Section 3: Media -->
          <div
            class="rounded-xl border border-[#e5e7eb] dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-[#111418] dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">perm_media</span>
              Site Photos
            </h3>
            <input type="file" name="new_photos[]" multiple accept="image/*" class="hidden" id="photoInput">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
              <!-- Existing photos -->
              <div id="photos-container" class="contents"></div>

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
          </div>
          <!-- Footer Actions -->
          <div class="flex items-center justify-between pt-4 border-t border-[#e5e7eb] dark:border-slate-800">
            <div class="flex flex-col">
              <span class="text-xs text-[#617589] dark:text-slate-500">Last modified by Admin User</span>
              <span class="text-xs text-[#617589] dark:text-slate-500">Oct 24, 2023 at 4:30 PM</span>
            </div>
            <button type="button" onclick="openDeleteModal()"
              class="text-red-600 hover:text-red-700 text-sm font-bold flex items-center gap-2 px-3 py-2 rounded hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
              <span class="material-symbols-outlined">delete</span>
              Delete Location
            </button>
          </div>
        </div>
        </form>
      </div>
    </main>
  </div>
</div>
<div id="deleteLocationModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-[#111a22] rounded-xl p-6 w-[420px]">
    <h3 class="text-lg font-bold text-red-600 mb-3">
      Confirm Delete
    </h3>

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
      Are you sure you want to delete this location?
      This action can be undone later.
    </p>

    <div class="flex justify-end gap-3">
      <button onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
        No
      </button>

      <form id="deleteLocationForm" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
          Yes, Delete
        </button>
      </form>
    </div>
  </div>
</div>
<script>
let isEditing = false;
const input = document.getElementById('photoInput');
const preview = document.getElementById('photoPreview');
let selectedFiles = [];
const MAX_FILES = 7;
const MAX_SIZE_MB = 5;

function selectLocation(element) {
  // active item
  document.querySelectorAll('.location-item')
    .forEach(el => el.classList.remove('active'));
  element.classList.add('active');

  // show form
  document.getElementById('emptyState').classList.add('hidden');
  document.getElementById('detailWrapper').classList.remove('hidden');
  document.getElementById('locationForm').classList.remove('hidden');

  // fill fields
  const data = JSON.parse(element.getAttribute('data-json'));
  document.getElementById('field-id').value = data.id;
  document.getElementById('field-name').value = data.industry_name;
  document.getElementById('field-description').value = data.description;


  document.getElementById('field-street').value = data.street;
  document.getElementById('field-city').value = data.city;
  document.getElementById('field-state').value = data.state_province;
  document.getElementById('field-zip').value = data.zipcode;
  document.getElementById('field-country').value = data.country;
  const photosContainer = document.getElementById('photos-container');
  photosContainer.innerHTML = '';
  if (data.photos && data.photos.length > 0) {
    data.photos.forEach(photo => {
      const imgHtml = `
        <div class="relative aspect-square group rounded-lg overflow-hidden">
          <input type="hidden" name="keep_photos[]" value="${photo.id}">
          
          <div class="absolute inset-0 bg-cover bg-center"
            style="background-image:url('/storage/${photo.img_url}')">
          </div>

          <button type="button"
            onclick="removePhoto(this, ${photo.id})"
            class="photo-delete-btn hidden absolute top-1 right-1 bg-red-600 text-white rounded-full p-1">
            ✕
          </button>
        </div>`;
      photosContainer.insertAdjacentHTML('beforeend', imgHtml);
    });
  } else {
    photosContainer.innerHTML = '<p class="col-span-full text-sm text-gray-500">No photos uploaded yet.</p>';
  }

  const mapBackground = document.getElementById('map-background');
  const mapLabel = document.getElementById('map-label');
  if (data.city) {
    // Cập nhật text hiển thị dưới Pin
    mapLabel.innerText = data.city;

    // Cập nhật hình nền bản đồ từ Mapbox Static API
    const cityEncoded = encodeURIComponent(data.city);
    // Nếu không muốn dùng Token/API, ta dùng ảnh vệ tinh placeholder theo từ khóa:
    const mapUrl = `https://static-maps.yandex.ru/1.x/?lang=en_US&ll=0,0&text=${cityEncoded}&z=12&l=map&size=450,240`;
    mapBackground.style.backgroundImage = `url('${mapUrl}')`;
    mapBackground.style.opacity = "1";
  }
  // set form action PUT /locations/{id}
  const form = document.getElementById('locationForm');
  form.action = `/locations/${data.id}`;

  toggleEdit(false);
}

function toggleEdit(isEdit) {
  isEditing = isEdit;
  const container = document.getElementById('detailWrapper');
  const inputs = container.querySelectorAll('input, textarea');

  inputs.forEach(el => {
    if (el.id !== 'field-id') {
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        el.readOnly = !isEdit;
      }

      el.classList.toggle('ring-2', isEdit);
      el.classList.toggle('ring-primary/50', isEdit);
      el.classList.toggle('cursor-not-allowed', !isEdit);
    }
  });

  document.getElementById('btn-edit').classList.toggle('hidden', isEdit);
  document.getElementById('btn-cancel').classList.toggle('hidden', !isEdit);
  document.getElementById('btn-save').classList.toggle('hidden', !isEdit);
  document.querySelectorAll('.photo-delete-btn')
    .forEach(btn => btn.classList.toggle('hidden', !isEdit));
}

function openDeleteModal() {
  const id = document.getElementById('field-id').value; // Lấy ID của địa điểm đang hiển thị
  if (!id) return;
  const form = document.getElementById('deleteLocationForm');
  form.action = `/locations/${id}/delete`;

  const modal = document.getElementById('deleteLocationModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteLocationModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

function removePhoto(btn, photoId) {
  if (!isEditing) return;
  const wrapper = btn.closest('.relative');

  const keepInput = wrapper.querySelector('input[name="keep_photos[]"]');
  if (keepInput) keepInput.remove();

  wrapper.insertAdjacentHTML(
    'beforeend',
    `<input type="hidden" name="delete_photos[]" value="${photoId}">`
  );

  wrapper.style.display = 'none';
}

input.addEventListener('change', () => {
  if (!isEditing) {
    input.value = '';
    return;
  }

  const newFiles = Array.from(input.files);

  newFiles.forEach(file => {
    if (selectedFiles.length >= MAX_FILES) return;

    if (file.size > MAX_SIZE_MB * 1024 * 1024) {
      alert(`File ${file.name} quá lớn!`);
      return;
    }

    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
      alert(`File ${file.name} không đúng định dạng!`);
      return;
    }

    selectedFiles.push(file);
  });

  syncAndRender();
});

function syncAndRender() {
  const dt = new DataTransfer();
  selectedFiles.forEach(file => dt.items.add(file));
  input.files = dt.files;

  preview.innerHTML = '';

  selectedFiles.forEach((file, index) => {
    const url = URL.createObjectURL(file);

    const item = document.createElement('div');
    item.className = 'relative aspect-square group rounded-lg overflow-hidden';

    item.innerHTML = `
      <div class="absolute inset-0 bg-cover bg-center"
        style="background-image:url('${url}')"></div>
      <div onclick="event.stopPropagation(); removeImage(${index})"
        class="absolute top-2 right-2 p-1 bg-black/50 rounded-full text-white
              opacity-0 group-hover:opacity-100 hover:bg-red-500">
        <span class="material-symbols-outlined text-sm">close</span>
      </div>
    `;

    preview.appendChild(item);
  });
}

function removeImage(index) {
  selectedFiles.splice(index, 1);
  syncAndRender();
}

// reset upload preview
selectedFiles = [];
input.value = '';
document.getElementById('photoPreview').innerHTML = '';
</script>
@endsection