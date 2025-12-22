@extends('layouts.app')
@section('title','manage_locations')
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
</style>
@endpush
@section('content')
<div class="relative flex h-screen w-full flex-col overflow-hidden">
  <!-- Top Navigation -->
  <header
    class="flex shrink-0 items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f4] dark:border-b-slate-800 bg-white dark:bg-slate-900 px-6 lg:px-10 py-3 z-20">
    <div class="flex items-center gap-4 text-[#111418] dark:text-white">
      <div class="size-8 flex items-center justify-center bg-primary/10 rounded-lg text-primary">
        <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
      </div>
      <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Admin Portal</h2>
    </div>
    <div class="flex flex-1 justify-end gap-8">
      <div class="hidden lg:flex items-center gap-9">
        <a class="text-[#111418] dark:text-slate-200 text-sm font-medium leading-normal hover:text-primary transition-colors"
          href="#">Dashboard</a>
        <a class="text-primary text-sm font-bold leading-normal" href="#">Locations</a>
        <a class="text-[#111418] dark:text-slate-200 text-sm font-medium leading-normal hover:text-primary transition-colors"
          href="#">Clients</a>
        <a class="text-[#111418] dark:text-slate-200 text-sm font-medium leading-normal hover:text-primary transition-colors"
          href="#">Projects</a>
        <a class="text-[#111418] dark:text-slate-200 text-sm font-medium leading-normal hover:text-primary transition-colors"
          href="#">Evaluations</a>
      </div>
      <div class="flex items-center gap-4">
        <button class="flex items-center justify-center text-[#111418] dark:text-white lg:hidden">
          <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-white shadow-sm"
          data-alt="User profile picture showing a smiling professional"
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBPJK7egpjejhHiWqFz4YUZNAxmftk_xNKui2cHwJST3-MtOI-i9bPV2hm1ZOjJhnX80RynVS-WlYgh8A3GFE0dnLvDgMX3jo0uy8iG73XxlRU4qa63OhiqitAva_wtQqBcVyvo9Eju0WPYMpHPrG8YLd0nvaPeUjunp_qtYfusbfcIeAAyi4Os1pCDMDtmm6L3iz3Qqq-KCpNpxAx9aW6j3iuHtBjBS40EUlVwVsY5RKJDCTy3d9aAl1JcLqHN0WGQNKA-h-bfwRjV");'>
        </div>
      </div>
    </div>
  </header>
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
        <!-- Active Item -->
        <div
          class="flex items-center gap-3 px-3 py-3 rounded-lg bg-primary/10 border border-primary/20 cursor-pointer transition-all">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Exterior view of a modern warehouse building"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBenwmakPbPHZDLm6TFY8Fh6l0DieqR-jzUQlnlVKyFKXkURZJp661xc0FgNI1-L2Z8rNXTzD3xjh1Puv2tEr9KrwzlI0OtjeRrdh_6ncu0HaYglxGwpa9K893jg-ROKdvtuw-Ry229P6OBujquqEpI1GjiDknEuYfRGL6DU5z0nv0xu6whiX7PXyP4bOrnTpnsIY6rVQYmE5MUQiXGPb5l15PWTh8dxzutddr0WcfKxZFJ4ETj7zED9n3mdvm0VQySbC5mz3XdbUMT");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p class="text-[#111418] dark:text-white text-sm font-bold leading-normal line-clamp-1">Central Warehouse
            </p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">123 Industrial
              Pkwy, Springfield</p>
          </div>
          <span class="material-symbols-outlined text-primary text-xl">arrow_forward_ios</span>
        </div>
        <!-- Inactive Items -->
        <div
          class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-[#f0f2f4] dark:hover:bg-slate-800 cursor-pointer transition-all group">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Glass office building in downtown area"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB65ICTFpt6buMXwd0nYCiEv3e5JSzoApF3my3IwcUJj6eHJYFi_f4icnr8kYySVFP-Hd4Cm0wcst6t8G_01owMMdCD_OfOErTu_LnXVcM-C4sr1ZdYV9WDpUfZHnY0m9jYbhCR6nGARmGbMajVM-dr22fDlppv5SjmV10kT-HsTVd8Nj3Op_HsVdGJh3uq9ygOx06SaauR6DYJH8YnQWf9sH9gakVoqTPlyAvBrkIlwKToUbeQHcHrx26vhLs1UXhbfl-efFhE8IQo");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p
              class="text-[#111418] dark:text-white text-sm font-medium leading-normal line-clamp-1 group-hover:text-primary transition-colors">
              Downtown Office</p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">456 Market St,
              Metropolis</p>
          </div>
        </div>
        <div
          class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-[#f0f2f4] dark:hover:bg-slate-800 cursor-pointer transition-all group">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Suburban distribution center with trucks"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB3LBv2iHAtCowqCxXDEY95d3Fx_tZlbqFloT42JMjjGG9NT1iCyGuw-kbyL2TvKXnIzRGgvfFXhKcl8_XgBzNdfLgUNQrKD_Mxlco-7gnToiYIqqMvOhAJU5iL15q7-u8oN809nak_moxx1NrFH6lkMqjqTXaZPUhzNwXRHJHGH4h5C3yYpJn0ZCWSiqrxKPdc0C-5rABag8Wxx5XRLkyAlMClcxGosC1CnHRJ1cKRzYW-ELLdk-KIbPOk_B88ZQ1g0IawcRKpQElV");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p
              class="text-[#111418] dark:text-white text-sm font-medium leading-normal line-clamp-1 group-hover:text-primary transition-colors">
              East Coast Distribution</p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">890 Harbor
              Blvd, Bay City</p>
          </div>
        </div>
        <div
          class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-[#f0f2f4] dark:hover:bg-slate-800 cursor-pointer transition-all group">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Modern tech park campus entrance"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBIDSjCzD-Rpa-hr_-SzzfTNL3WPdoem3cDN2GH94lV1uNRzwZxFZOoc6LhzAgJVGJnLEFuO_igWM0sVFz9d8jxDe7IxUrNelJTpnP3gUx3oUk2rXCfT43PyXiTmLQhRk0aV13Ay2yj-vjY5xBamAUHZ1qeIccqwX1wmiAUv7WidzkneKYHI8HINNzi2YDkTfDd1YfpHUYJnN0cSrKV45KbUg2i1mC3OqDtYkUbpv00ZNp-Z9FrG1yWw-_GZbAryuhQU2iJk0_Babxv");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p
              class="text-[#111418] dark:text-white text-sm font-medium leading-normal line-clamp-1 group-hover:text-primary transition-colors">
              Tech Park Site B</p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">2020
              Innovation Dr, Silicon Valley</p>
          </div>
        </div>
        <div
          class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-[#f0f2f4] dark:hover:bg-slate-800 cursor-pointer transition-all group">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-12 shrink-0"
            data-alt="Construction site in early development"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAnB2ItoYhwN7efrfYqKICPSWuh5xVemcR8WhJiKMa3dLrLAzcu6MS_8lMGj-nMROI7CYGz30iBOTvQI0TigJxNtvhGOhJI5Yg0E6OFeBfEkHx6CHe33AgEzJW-wVvZdSpFD_H-_AgtF3hny9t1iB6mK8Qn1i1vpVWz0sug6EYrqAxMsFswHldZRRSYrpZPJoKkDgsExVlexYC2HS1KFIqJYUBvGNbmLp4bXkoQzTc0J7ZxSaiC78rN9wYw6NLQu-KkwnqZlngqvamk");'>
          </div>
          <div class="flex flex-col justify-center flex-1 min-w-0">
            <p
              class="text-[#111418] dark:text-white text-sm font-medium leading-normal line-clamp-1 group-hover:text-primary transition-colors">
              North Site Development</p>
            <p class="text-[#617589] dark:text-slate-400 text-xs font-normal leading-normal line-clamp-1">77 Northern
              Pike, Winterfell</p>
          </div>
        </div>
      </div>
      <!-- Sidebar Footer -->
      <div class="p-4 border-t border-[#f0f2f4] dark:border-slate-800">
        <button
          class="flex w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary hover:bg-blue-600 text-white text-sm font-bold leading-normal tracking-[0.015em] transition-colors shadow-sm">
          <span class="material-symbols-outlined mr-2 text-lg">add</span>
          <span class="truncate">Add New Location</span>
        </button>
      </div>
    </aside>
    <!-- Right Content Area (Detail View) -->
    <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark p-6 lg:p-10">
      <div class="max-w-[960px] mx-auto flex flex-col gap-6">
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
          <div class="flex gap-3">
            <button
              class="flex h-10 items-center justify-center rounded-lg border border-[#e5e7eb] dark:border-slate-700 bg-white dark:bg-slate-800 px-4 text-sm font-bold text-[#111418] dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
              Cancel
            </button>
            <button
              class="flex h-10 items-center justify-center rounded-lg bg-primary px-6 text-sm font-bold text-white hover:bg-blue-600 shadow-sm transition-colors">
              Save Changes
            </button>
          </div>
        </div>
        <!-- Form Content -->
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
                <input
                  class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50 placeholder:text-[#617589]"
                  type="text" value="Central Warehouse" />
              </div>
              <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Description</label>
                <textarea
                  class="w-full resize-none rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50 placeholder:text-[#617589]"
                  rows="3">Main distribution hub for the mid-west region. Handles large freight and logistics operations.</textarea>
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
                  <input
                    class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                    type="text" value="123 Industrial Pkwy" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">City</label>
                    <input
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="Springfield" />
                  </div>
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">State / Province</label>
                    <input
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="IL" />
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Zip Code</label>
                    <input
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50"
                      type="text" value="62704" />
                  </div>
                  <div class="flex flex-col gap-2">
                    <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Country</label>
                    <select
                      class="w-full rounded-lg border-none bg-[#f0f2f4] dark:bg-slate-800 px-4 py-3 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary/50">
                      <option selected="">United States</option>
                      <option>Canada</option>
                      <option>Mexico</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- Map Widget Placeholder -->
              <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-[#111418] dark:text-slate-200">Pin Location</label>
                <div
                  class="relative w-full h-full min-h-[240px] rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 group cursor-crosshair border border-transparent hover:border-primary/50 transition-colors">
                  <div class="absolute inset-0 bg-cover bg-center opacity-80 group-hover:opacity-100 transition-opacity"
                    data-alt="Map view of Springfield Illinois centered on industrial park"
                    data-location="Springfield, Illinois"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBaCu-tp1bfpQNnJ-IXFZTAVYOUJQDaU_tAISVmvT_niwU6TpF8VO_ETONeOU59ybeRvcHBl4OY32ie4cpGnU0rHIFwslazEw65JpCKxxz3NtitZgYrU9TkntmZXr784qh1DW-1rPiaTYfkE9FSyTLv4Us11KCUOSvZmucbHvM7qhKuXLwkoc85geT4MTLlrOLvULfRSo3-nXMsuotJn-3flhhBfo7NmL5vDkEjU9YolbgU8RDfTrHhQ-TKDKkYO2OQAhPlIg_tJjN7");'>
                  </div>
                  <!-- Map Pin -->
                  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                    <span class="material-symbols-outlined text-4xl text-red-600 drop-shadow-md">location_on</span>
                    <div
                      class="bg-white dark:bg-slate-900 text-xs font-bold px-2 py-1 rounded shadow-md mt-1 whitespace-nowrap">
                      Lat: 39.78, Long: -89.65</div>
                  </div>
                  <!-- Map Controls -->
                  <div class="absolute bottom-3 right-3 flex flex-col gap-2">
                    <button
                      class="size-8 bg-white dark:bg-slate-800 rounded shadow-md flex items-center justify-center hover:bg-slate-50 dark:hover:bg-slate-700 text-[#111418] dark:text-white">
                      <span class="material-symbols-outlined text-lg">add</span>
                    </button>
                    <button
                      class="size-8 bg-white dark:bg-slate-800 rounded shadow-md flex items-center justify-center hover:bg-slate-50 dark:hover:bg-slate-700 text-[#111418] dark:text-white">
                      <span class="material-symbols-outlined text-lg">remove</span>
                    </button>
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
          </div>
          <!-- Footer Actions -->
          <div class="flex items-center justify-between pt-4 border-t border-[#e5e7eb] dark:border-slate-800">
            <div class="flex flex-col">
              <span class="text-xs text-[#617589] dark:text-slate-500">Last modified by Admin User</span>
              <span class="text-xs text-[#617589] dark:text-slate-500">Oct 24, 2023 at 4:30 PM</span>
            </div>
            <button
              class="text-red-600 hover:text-red-700 text-sm font-bold flex items-center gap-2 px-3 py-2 rounded hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
              <span class="material-symbols-outlined">delete</span>
              Delete Location
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection