@extends('layouts.app')
@section('title','manage_projects')
@push('styles')
<style>
body {
  font-family: 'Manrope', sans-serif;
}

/* Custom scrollbar for better look in containers */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
@endpush
@section('content')
<!-- Top Navigation -->
<header
  class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f4] dark:border-gray-800 bg-white dark:bg-[#1a2632] px-10 py-3 sticky top-0 z-50">
  <div class="flex items-center gap-4 text-[#111418] dark:text-white">
    <div class="size-6 text-primary">
      <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
    </div>
    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Admin Portal</h2>
  </div>
  <div class="flex flex-1 justify-end gap-8">
    <div class="hidden md:flex items-center gap-9">
      <a class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Dashboard</a>
      <a class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Projects</a>
      <a class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Clients</a>
      <a class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Reports</a>
    </div>
    <div
      class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-transparent hover:border-primary cursor-pointer"
      data-alt="User profile avatar image"
      style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA1IUHqi-qaEshJUQGkfg8eUm_MulWE3mWwFPOjmwjv09VUrwBCTH24d7G8ZfCI-Wb5aXb3Sks6LPztI2RaUAiOL6VIH1-Q585lNUBO3KarHbHeGUsF7L3wVu9pNlfpC_h3Qr9cpAFBAIBcCxFKVfgq-exUnWI8inxuajbczYF1vDMYTMNmGG2usZfD3iMnw8VoW6E2GQOzpi2j6G23CfaJvRAKF4pzefszbe5C03K7Y_1TBRAMEfRKJQBPrBHotAQrCfj-9UIId58j");'>
    </div>
  </div>
</header>
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors"
        href="#">Dashboard</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <a class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal hover:text-primary transition-colors"
        href="#">Projects</a>
      <span class="text-[#617589] dark:text-gray-400 text-base font-medium leading-normal">/</span>
      <span class="text-[#111418] dark:text-white text-base font-medium leading-normal">Create New Project</span>
    </div>
    <!-- Page Header -->
    <div class="flex flex-wrap justify-between items-end gap-3 px-4">
      <div class="flex min-w-72 flex-col gap-3">
        <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Create New
          Project</h1>
        <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">Configure project details,
          assign stakeholders, and set evaluation metrics.</p>
      </div>
      <div class="flex gap-3">
        <button
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-transparent text-[#111418] dark:text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-gray-100 dark:hover:bg-gray-800 border border-gray-300 dark:border-gray-600 transition-all">
          <span class="truncate">Cancel</span>
        </button>
        <button
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-blue-600 shadow-md transition-all">
          <span class="truncate">Save Project</span>
        </button>
      </div>
    </div>
    <!-- Main Form Content -->
    <form class="flex flex-col gap-6">
      <!-- Section 1: General Information -->
      <div
        class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <h2
          class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          General Information
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <label class="flex flex-col gap-2 col-span-2 md:col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Project Name <span
                class="text-red-500">*</span></span>
            <input
              class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589] dark:placeholder:text-gray-500"
              placeholder="e.g. Q4 Regional Retail Expansion" required="" type="text" />
          </label>
          <label class="flex flex-col gap-2 col-span-2 md:col-span-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Description</span>
            <textarea
              class="form-textarea w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white p-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-[#617589] dark:placeholder:text-gray-500 resize-none h-32"
              placeholder="Briefly describe the goals and scope of this project..."></textarea>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Start Date</span>
            <div class="relative">
              <input
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                type="date" />
            </div>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">End Date</span>
            <div class="relative">
              <input
                class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                type="date" />
            </div>
          </label>
        </div>
      </div>
      <!-- Section 2: Assignments -->
      <div
        class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <h2
          class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          Assignments
        </h2>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Clients Assignment -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Assign Clients</label>
            <div class="relative group">
              <div
                class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all cursor-text">
                <span class="material-symbols-outlined text-[#617589] mr-2">search</span>
                <div class="flex flex-wrap gap-2 flex-1">
                  <div class="flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded text-sm font-medium">
                    Acme Corp
                    <button class="hover:text-red-500 flex items-center" type="button"><span
                        class="material-symbols-outlined text-sm">close</span></button>
                  </div>
                  <input
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white"
                    placeholder="Search clients..." type="text" />
                </div>
                <span
                  class="material-symbols-outlined text-[#617589] cursor-pointer hover:text-primary">expand_more</span>
              </div>
              <!-- Dropdown simulation -->
              <div
                class="absolute top-full left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg z-10 hidden group-focus-within:block max-h-48 overflow-y-auto">
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> Globex Inc.
                </div>
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> Stark
                  Industries
                </div>
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> Wayne
                  Enterprises
                </div>
              </div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Select the clients associated with this project.</p>
          </div>
          <!-- Locations Assignment -->
          <div class="flex flex-col gap-3">
            <label class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal">Assign
              Locations</label>
            <div class="relative group">
              <div
                class="flex items-center w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] px-3 py-2 min-h-[48px] focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-all cursor-text">
                <span class="material-symbols-outlined text-[#617589] mr-2">location_on</span>
                <div class="flex flex-wrap gap-2 flex-1">
                  <input
                    class="bg-transparent border-none outline-none focus:ring-0 p-0 text-sm flex-1 min-w-[120px] dark:text-white"
                    placeholder="Search locations..." type="text" />
                </div>
                <span
                  class="material-symbols-outlined text-[#617589] cursor-pointer hover:text-primary">expand_more</span>
              </div>
              <!-- Dropdown simulation -->
              <div
                class="absolute top-full left-0 w-full mt-1 bg-white dark:bg-[#253240] border border-[#dbe0e6] dark:border-gray-600 rounded-lg shadow-lg z-10 hidden group-focus-within:block max-h-48 overflow-y-auto">
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> New York HQ
                </div>
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> London
                  Office
                </div>
                <div
                  class="px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm dark:text-gray-200 flex items-center gap-2">
                  <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" /> Tokyo Branch
                </div>
              </div>
            </div>
            <p class="text-xs text-[#617589] dark:text-gray-400">Specify where this project will be executed.</p>
          </div>
        </div>
      </div>
      <!-- Section 3: Evaluation Criteria -->
      <div
        class="bg-white dark:bg-[#1a2632] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-gray-700 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-[#f0f2f4] dark:border-gray-700">
          <div class="flex flex-col">
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]">
              Evaluation Criteria</h2>
            <p class="text-sm text-[#617589] dark:text-gray-400 mt-1">Define the metrics used to evaluate success.
              Weights must sum to 100%.</p>
          </div>
          <button
            class="flex items-center gap-2 text-primary font-bold text-sm bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-lg transition-colors"
            type="button">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Add Criterion
          </button>
        </div>
        <div class="p-6">
          <!-- Header Row -->
          <div
            class="hidden md:grid grid-cols-12 gap-4 pb-3 border-b border-[#f0f2f4] dark:border-gray-700 mb-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
            <div class="col-span-4">Criterion Name</div>
            <div class="col-span-2">Weight (%)</div>
            <div class="col-span-5">Description</div>
            <div class="col-span-1 text-center">Action</div>
          </div>
          <!-- Criterion Item 1 -->
          <div
            class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start mb-6 md:mb-4 pb-4 md:pb-0 border-b md:border-b-0 border-[#f0f2f4] dark:border-gray-700 last:mb-0">
            <div class="col-span-1 md:col-span-4">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Name</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="e.g. Quality" type="text" value="Customer Satisfaction" />
            </div>
            <div class="col-span-1 md:col-span-2">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Weight (%)</label>
              <div class="relative">
                <input
                  class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary pr-8"
                  type="number" value="40" />
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
              </div>
            </div>
            <div class="col-span-1 md:col-span-5">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Description</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="Brief explanation..." type="text" value="Based on post-service surveys" />
            </div>
            <div class="col-span-1 flex justify-center items-center h-10">
              <button
                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                type="button">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </div>
          <!-- Criterion Item 2 -->
          <div
            class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start mb-6 md:mb-4 pb-4 md:pb-0 border-b md:border-b-0 border-[#f0f2f4] dark:border-gray-700 last:mb-0">
            <div class="col-span-1 md:col-span-4">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Name</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="e.g. Quality" type="text" value="Time Efficiency" />
            </div>
            <div class="col-span-1 md:col-span-2">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Weight (%)</label>
              <div class="relative">
                <input
                  class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary pr-8"
                  type="number" value="30" />
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
              </div>
            </div>
            <div class="col-span-1 md:col-span-5">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Description</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="Brief explanation..." type="text" value="Delivery within SLA timeframe" />
            </div>
            <div class="col-span-1 flex justify-center items-center h-10">
              <button
                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                type="button">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </div>
          <!-- Criterion Item 3 (New/Empty) -->
          <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
            <div class="col-span-1 md:col-span-4">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Name</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="Enter criterion name" type="text" />
            </div>
            <div class="col-span-1 md:col-span-2">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Weight (%)</label>
              <div class="relative">
                <input
                  class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary pr-8"
                  placeholder="0" type="number" />
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
              </div>
            </div>
            <div class="col-span-1 md:col-span-5">
              <label class="md:hidden text-xs font-bold text-[#617589] mb-1 block">Description</label>
              <input
                class="w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#253240] text-[#111418] dark:text-white h-10 px-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                placeholder="Optional description..." type="text" />
            </div>
            <div class="col-span-1 flex justify-center items-center h-10">
              <button
                class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                type="button">
                <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          </div>
          <!-- Total Weight Summary -->
          <div class="mt-6 flex justify-end items-center gap-4 pt-4 border-t border-[#f0f2f4] dark:border-gray-700">
            <span class="text-sm font-medium text-[#617589] dark:text-gray-400">Total Weight:</span>
            <div class="flex items-center gap-2">
              <span class="text-lg font-bold text-[#111418] dark:text-white">70%</span>
              <span class="material-symbols-outlined text-amber-500 text-base" title="Total must be 100%">warning</span>
              <span class="text-xs text-amber-500 font-medium">Must equal 100%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Actions (Mobile Sticky) -->
      <div
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#1a2632] border-t border-[#f0f2f4] dark:border-gray-700 p-4 md:hidden z-40 flex gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <button class="flex-1 h-12 rounded-lg bg-gray-100 text-[#111418] font-bold text-sm">Cancel</button>
        <button class="flex-1 h-12 rounded-lg bg-primary text-white font-bold text-sm">Save Project</button>
      </div>
      <!-- Spacer for mobile footer -->
      <div class="h-16 md:hidden"></div>
    </form>
  </div>
</main>
@endsection