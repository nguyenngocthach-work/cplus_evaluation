@extends('layouts.app')
@section('title','Evaluation Report Export')
@section('content')
<!-- Top Navigation -->
<header
  class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f4] dark:border-b-[#2a3441] bg-white dark:bg-[#1A2633] px-10 py-3 sticky top-0 z-50">
  <div class="flex items-center gap-4 text-[#111418] dark:text-white">
    <div class="size-8 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
      <span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
    </div>
    <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Evaluation Manager
    </h2>
  </div>
  <div class="flex flex-1 justify-end gap-8">
    <div class="hidden md:flex items-center gap-9">
      <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Dashboard</a>
      <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Projects</a>
      <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Clients</a>
      <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal hover:text-primary transition-colors"
        href="#">Reports</a>
    </div>
    <div class="flex items-center gap-4">
      <button
        class="flex items-center justify-center rounded-full size-10 bg-gray-100 dark:bg-gray-800 text-[#111418] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined">notifications</span>
      </button>
      <div
        class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border border-gray-200 dark:border-gray-700"
        data-alt="User profile picture placeholder"
        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCBKUX5W45g_2XHh8cLB-jp5gD0wYIWrD4Bqd1Vk8g1A883ovKUaiLmni-ZPEIUo8qHC4xWqKR_PTb8DCjWtNqd83ixHsr2ffhC9gU-CNbQmLWn1I6D1n5zDFEuhsLc_Gj3dd1adABzxNCf_OPyw6EF-6pLtLv7La-2TllWpiMDsycP1xYCrMSt-hphTLz2Pv5vmfRZj_-UpPQdq3tY6D2v3wMYbS-29SXr9SNdnYaE_uHIvjT8WjnBgOl7KPW78BO16mtJ0fhRrURu");'>
      </div>
    </div>
  </div>
</header>
<!-- Main Content Layout -->
<div class="flex-1 flex flex-col w-full max-w-[1440px] mx-auto px-4 md:px-10 py-6 pb-24">
  <!-- Breadcrumbs -->
  <div class="flex flex-wrap gap-2 py-2 mb-4">
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary" href="#">Home</a>
    <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary"
      href="#">Projects</a>
    <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary" href="#">Project
      Alpha</a>
    <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
    <span class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Export Report</span>
  </div>
  <!-- Header & Stats Area -->
  <div class="flex flex-col xl:flex-row gap-6 mb-8 justify-between items-start xl:items-end">
    <div class="flex flex-col gap-2">
      <h1 class="text-[#111418] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
        Export Evaluation Report</h1>
      <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">Review details and configure
        settings before generating the final PDF document.</p>
    </div>
    <!-- Summary Stats Widget -->
    <div class="flex flex-wrap gap-4 w-full xl:w-auto">
      <div
        class="flex min-w-[140px] flex-1 flex-col gap-1 rounded-lg p-4 border border-[#dbe0e6] dark:border-[#2a3441] bg-white dark:bg-[#1A2633] shadow-sm">
        <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Final Score</p>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-green-500">check_circle</span>
          <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">85%</p>
        </div>
      </div>
      <div
        class="flex min-w-[140px] flex-1 flex-col gap-1 rounded-lg p-4 border border-[#dbe0e6] dark:border-[#2a3441] bg-white dark:bg-[#1A2633] shadow-sm">
        <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Status</p>
        <p class="text-green-600 dark:text-green-400 text-2xl font-bold leading-tight">Pass</p>
      </div>
      <div
        class="flex min-w-[140px] flex-1 flex-col gap-1 rounded-lg p-4 border border-[#dbe0e6] dark:border-[#2a3441] bg-white dark:bg-[#1A2633] shadow-sm">
        <p class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">Issues Found</p>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-orange-500">warning</span>
          <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">12</p>
        </div>
      </div>
    </div>
  </div>
  <!-- Main Content Split -->
  <div class="flex flex-col lg:flex-row gap-8 items-start h-full">
    <!-- Sidebar Configuration -->
    <div class="w-full lg:w-[360px] flex flex-col gap-6 shrink-0">
      <!-- Report Settings Card -->
      <div class="bg-white dark:bg-[#1A2633] rounded-xl border border-[#dbe0e6] dark:border-[#2a3441] p-6 shadow-sm">
        <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight mb-5">Report Configuration</h3>
        <div class="flex flex-col gap-5">
          <!-- Input Group -->
          <div class="flex flex-col gap-2">
            <label class="text-[#111418] dark:text-white text-sm font-medium">Report Title</label>
            <input
              class="w-full bg-[#f6f7f8] dark:bg-[#101922] border border-[#dbe0e6] dark:border-[#2a3441] rounded-lg px-4 py-2.5 text-sm text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all"
              type="text" value="Safety &amp; Compliance Audit - Q3" />
          </div>
          <!-- Input Group -->
          <div class="flex flex-col gap-2">
            <label class="text-[#111418] dark:text-white text-sm font-medium">Prepared For</label>
            <input
              class="w-full bg-[#f6f7f8] dark:bg-[#101922] border border-[#dbe0e6] dark:border-[#2a3441] rounded-lg px-4 py-2.5 text-sm text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all"
              type="text" value="Client X Global Holdings" />
          </div>
          <hr class="border-[#f0f2f4] dark:border-[#2a3441]" />
          <!-- Toggles Group -->
          <div class="flex flex-col gap-4">
            <p class="text-[#617589] dark:text-gray-400 text-xs font-bold uppercase tracking-wider">Include Sections</p>
            <label class="flex items-center justify-between cursor-pointer group">
              <span class="text-[#111418] dark:text-white text-sm font-medium">Executive Summary</span>
              <div class="relative inline-flex items-center cursor-pointer">
                <input checked="" class="sr-only peer" type="checkbox" value="" />
                <div
                  class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                </div>
              </div>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <span class="text-[#111418] dark:text-white text-sm font-medium">Detailed Scoring</span>
              <div class="relative inline-flex items-center cursor-pointer">
                <input checked="" class="sr-only peer" type="checkbox" value="" />
                <div
                  class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                </div>
              </div>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <span class="text-[#111418] dark:text-white text-sm font-medium">Photo Evidence</span>
              <div class="relative inline-flex items-center cursor-pointer">
                <input checked="" class="sr-only peer" type="checkbox" value="" />
                <div
                  class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                </div>
              </div>
            </label>
            <label class="flex items-center justify-between cursor-pointer group">
              <span class="text-[#111418] dark:text-white text-sm font-medium">Evaluator Comments</span>
              <div class="relative inline-flex items-center cursor-pointer">
                <input class="sr-only peer" type="checkbox" value="" />
                <div
                  class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                </div>
              </div>
            </label>
          </div>
        </div>
      </div>
      <!-- Export Format -->
      <div class="bg-white dark:bg-[#1A2633] rounded-xl border border-[#dbe0e6] dark:border-[#2a3441] p-6 shadow-sm">
        <h3 class="text-[#111418] dark:text-white text-lg font-bold leading-tight mb-4">Export Format</h3>
        <div class="flex gap-4">
          <label class="flex-1 cursor-pointer">
            <input checked="" class="peer sr-only" name="format" type="radio" />
            <div
              class="flex flex-col items-center justify-center p-4 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] bg-[#f6f7f8] dark:bg-[#101922] peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
              <span class="material-symbols-outlined text-3xl mb-2 text-primary">picture_as_pdf</span>
              <span class="text-sm font-bold text-[#111418] dark:text-white">PDF</span>
            </div>
          </label>
          <label class="flex-1 cursor-pointer">
            <input class="peer sr-only" name="format" type="radio" />
            <div
              class="flex flex-col items-center justify-center p-4 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] bg-[#f6f7f8] dark:bg-[#101922] peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
              <span class="material-symbols-outlined text-3xl mb-2 text-[#617589]">csv</span>
              <span class="text-sm font-bold text-[#111418] dark:text-white">CSV</span>
            </div>
          </label>
        </div>
      </div>
    </div>
    <!-- Preview Area -->
    <div
      class="flex-1 w-full bg-[#e5e7eb] dark:bg-[#0d131a] rounded-xl border border-[#dbe0e6] dark:border-[#2a3441] p-8 overflow-hidden relative min-h-[800px] flex justify-center">
      <div
        class="absolute top-4 left-4 bg-black/70 backdrop-blur-md text-white px-3 py-1 rounded text-xs font-medium z-10 flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">visibility</span> Preview Mode
      </div>
      <!-- Paper Sheet (Simulated PDF) -->
      <!-- Use 'text-black' explicitly here as this is a paper preview and should look like ink on paper regardless of app theme -->
      <div
        class="bg-white text-black shadow-2xl w-full max-w-[700px] aspect-[1/1.41] p-8 md:p-12 flex flex-col gap-6 relative origin-top transform scale-100 transition-transform">
        <!-- PDF Header -->
        <div class="flex justify-between items-start border-b-2 border-primary pb-6">
          <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Safety &amp; Compliance Audit</h2>
            <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold">Project Alpha - Client X</p>
          </div>
          <div class="text-right flex flex-col items-end">
            <div class="size-10 bg-gray-900 text-white flex items-center justify-center rounded mb-2">
              <span class="font-bold text-xl">E</span>
            </div>
            <p class="text-xs text-gray-400">Date: Oct 24, 2023</p>
            <p class="text-xs text-gray-400">Ref: #EVAL-2938</p>
          </div>
        </div>
        <!-- Executive Summary Section -->
        <div class="flex flex-col gap-3">
          <h3 class="text-sm font-bold uppercase text-primary border-b border-gray-100 pb-1">Executive Summary</h3>
          <p class="text-xs leading-relaxed text-gray-600">
            The evaluation for Project Alpha indicates strong compliance with safety regulations.
            While the overall score of 85% meets the 'Pass' threshold, 12 minor issues were identified primarily in the
            storage protocols.
            Immediate corrective actions are recommended for the highlighted zones.
          </p>
        </div>
        <!-- Score Visualization (Mock) -->
        <div class="flex flex-col gap-3 mt-2">
          <h3 class="text-sm font-bold uppercase text-primary border-b border-gray-100 pb-1">Performance Breakdown</h3>
          <div class="grid grid-cols-2 gap-x-8 gap-y-4 py-2">
            <!-- Chart Item -->
            <div class="flex flex-col gap-1">
              <div class="flex justify-between text-xs font-medium">
                <span>Safety Protocols</span>
                <span class="font-bold">92%</span>
              </div>
              <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary w-[92%]"></div>
              </div>
            </div>
            <!-- Chart Item -->
            <div class="flex flex-col gap-1">
              <div class="flex justify-between text-xs font-medium">
                <span>Equipment Quality</span>
                <span class="font-bold">78%</span>
              </div>
              <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-orange-400 w-[78%]"></div>
              </div>
            </div>
            <!-- Chart Item -->
            <div class="flex flex-col gap-1">
              <div class="flex justify-between text-xs font-medium">
                <span>Staff Compliance</span>
                <span class="font-bold">88%</span>
              </div>
              <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary w-[88%]"></div>
              </div>
            </div>
            <!-- Chart Item -->
            <div class="flex flex-col gap-1">
              <div class="flex justify-between text-xs font-medium">
                <span>Documentation</span>
                <span class="font-bold">82%</span>
              </div>
              <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary w-[82%]"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Findings Table Preview -->
        <div class="flex flex-col gap-3 mt-2 flex-1">
          <h3 class="text-sm font-bold uppercase text-primary border-b border-gray-100 pb-1">Detailed Findings (Preview)
          </h3>
          <table class="w-full text-left text-xs border-collapse">
            <thead>
              <tr class="border-b border-gray-200">
                <th class="py-2 font-bold text-gray-700 w-16">ID</th>
                <th class="py-2 font-bold text-gray-700">Item</th>
                <th class="py-2 font-bold text-gray-700 w-20">Status</th>
                <th class="py-2 font-bold text-gray-700 w-16 text-right">Score</th>
              </tr>
            </thead>
            <tbody class="text-gray-600">
              <tr class="border-b border-gray-50">
                <td class="py-2">1.01</td>
                <td class="py-2">Fire Extinguisher Checks</td>
                <td class="py-2"><span
                    class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[10px] font-bold">PASS</span></td>
                <td class="py-2 text-right">5/5</td>
              </tr>
              <tr class="border-b border-gray-50">
                <td class="py-2">1.02</td>
                <td class="py-2">Emergency Exit Signage</td>
                <td class="py-2"><span
                    class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[10px] font-bold">PASS</span></td>
                <td class="py-2 text-right">5/5</td>
              </tr>
              <tr class="border-b border-gray-50">
                <td class="py-2">1.03</td>
                <td class="py-2">Pathway Clearance</td>
                <td class="py-2"><span
                    class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-bold">FAIL</span></td>
                <td class="py-2 text-right">0/5</td>
              </tr>
              <tr class="border-b border-gray-50">
                <td class="py-2">1.04</td>
                <td class="py-2">PPE Availability</td>
                <td class="py-2"><span
                    class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-[10px] font-bold">PASS</span></td>
                <td class="py-2 text-right">5/5</td>
              </tr>
              <tr class="border-b border-gray-50">
                <td class="py-2">1.05</td>
                <td class="py-2">First Aid Kit Stock</td>
                <td class="py-2"><span
                    class="bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded text-[10px] font-bold">WARN</span></td>
                <td class="py-2 text-right">3/5</td>
              </tr>
            </tbody>
          </table>
          <!-- Gradient overlay to signify continuation -->
          <div class="h-20 w-full bg-gradient-to-t from-white to-transparent -mt-20 z-10 relative"></div>
        </div>
        <!-- PDF Footer -->
        <div class="mt-auto border-t border-gray-100 pt-4 flex justify-between items-center text-[10px] text-gray-400">
          <p>Generated by Evaluation Manager Platform</p>
          <p>Page 1 of 4</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Sticky Action Bar -->
<div
  class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#1A2633] border-t border-[#dbe0e6] dark:border-[#2a3441] px-6 py-4 z-40 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
  <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="text-sm text-[#617589] dark:text-gray-400 hidden md:block">
      <span>Exporting 14 pages • Estimated file size: 2.4 MB</span>
    </div>
    <div class="flex items-center gap-3 w-full md:w-auto">
      <button
        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] text-[#111418] dark:text-white font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
        Cancel
      </button>
      <button
        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] text-[#111418] dark:text-white font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-[18px]">mail</span>
        Email
      </button>
      <button
        class="flex-[2] md:flex-none px-8 py-2.5 rounded-lg bg-primary text-white font-bold text-sm hover:bg-blue-600 transition-colors shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-[18px]">download</span>
        Download PDF
      </button>
    </div>
  </div>
</div>
@endsection