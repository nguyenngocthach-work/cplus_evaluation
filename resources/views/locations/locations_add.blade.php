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
  <form id="clientForm" method="POST" action="{{ route('locations.store') }}"
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
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          <!-- Existing Photo 1 -->
          <div class="relative aspect-square group rounded-lg overflow-hidden cursor-pointer">
            <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
              data-alt="Interior of warehouse with high shelves"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAwS-weNo5EPQoerlmi1KbD3tgSxQagqvvG-qPjtY7jTkAZVvXRu_vErJMPpQy5BGkEi5drFT4iQxrb0k6XmF9GDSBKGxZJRSsA5W-62N79e2I--QHqJkVNjCY2ilrGI9RgHe3f6d_BDdL2tY9DWKIMGZe6wvfMk3peWFhzFlmmZT-0gSFfVn-fc9y0lrYDM6oN1rally4T6f7gAPx4rGMDV0zVTeMY1_9s0fn_KFaT65QjFySd5MbA2L5tzcDezKNxBL9iAn2PNoTn");'>
            </div>
            <div
              class="absolute top-2 right-2 p-1 bg-black/50 rounded-full text-white opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500">
              <span class="material-symbols-outlined text-sm block">close</span>
            </div>
          </div>
          <!-- Existing Photo 2 -->
          <div class="relative aspect-square group rounded-lg overflow-hidden cursor-pointer">
            <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
              data-alt="Loading dock area with trucks"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDrtgpOc_19akL4p_9zguaN6kalQN1CdU9MbluA_tF03dg7dkVe9wQEn_SMGn0VJvMPZ_KrS9mnvR9_2LKHUGqRSBJlw4zbfkcWd07ZY5s7hQuCqFKHRIOCnpGwTL2s1jilPMxHuLqs4YcMpOH0PwpwfJIwkMzhLH2UiHivtQ-AEHOIe4f4k-8FE0JVjCsM_e8fQ6zR9xU3n7cBH_j2OCenypFfbp9fp1XwiXlfuMPPnNLeW8NwmP0ja52-aF9Jkvn4aI_sp83NHT0m");'>
            </div>
            <div
              class="absolute top-2 right-2 p-1 bg-black/50 rounded-full text-white opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500">
              <span class="material-symbols-outlined text-sm block">close</span>
            </div>
          </div>
          <!-- Existing Photo 3 -->
          <div class="relative aspect-square group rounded-lg overflow-hidden cursor-pointer">
            <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
              data-alt="Office space inside warehouse"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA0WH3kVrmWYxqhDNDkgZR2l9-hVhK7_9bh_085iQofrHTeKHBjJ8RAqAtidf_V0eb3WHpsxJ8SY5Jt4imkO4qAJSy4Z_41TMQJ00UisXMT-OUUKpvwKBFThjA0coBi-JnxU0DHQWlBDBbzxLClqS7KMhqBT3L-I3ad1Mu97ExQsX-6Af-Pf_w5TeiJpf4O0z_0rXZb7QBVxd0NIc8ukZbaiZac5wZ3DfkwX8tQh4n52yzClhA9SLe9EA9CFu5V0vj0l20wqUE16yKn");'>
            </div>
            <div
              class="absolute top-2 right-2 p-1 bg-black/50 rounded-full text-white opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500">
              <span class="material-symbols-outlined text-sm block">close</span>
            </div>
          </div>
          <!-- Upload New -->
          <div
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
@endsection