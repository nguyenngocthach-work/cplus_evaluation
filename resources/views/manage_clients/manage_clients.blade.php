@extends('layouts.app')
@section('title','Manage Clients')
@section('content')
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
  <!-- Top Navigation -->
  <div class="layout-container flex h-full grow flex-col">
    <!-- Main Content -->
    <main class="flex flex-1 justify-center py-5 px-4 md:px-10 lg:px-40">
      <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 px-4 py-2">
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:underline"
            href="#">Dashboard</a>
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
          <a href="{{ route('admin.clients.create.screen') }}"
            class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white hover:bg-blue-600 transition-colors text-sm font-bold leading-normal tracking-[0.015em] shadow-sm">
            <span class="material-symbols-outlined mr-2 !text-lg">add</span>
            <span class="truncate">Add New Client</span>
          </a>
        </div>
        <!-- Toolbar / Filters -->
        <div
          class="flex flex-col md:flex-row justify-between gap-4 px-4 py-4 bg-white dark:bg-[#111a22] rounded-t-xl border-x border-t border-[#dbe0e6] dark:border-gray-700 mt-4">
          <div class="flex flex-1 gap-4 flex-col md:flex-row">
            <label class="flex flex-col min-w-40 flex-1 max-w-md relative group">
              <span class="material-symbols-outlined absolute left-4 top-3.5 text-[#617589]">search</span>
              <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] focus:border-primary h-12 placeholder:text-[#617589] pl-12 pr-4 text-sm font-normal leading-normal transition-all"
                placeholder="Search clients by name, email, or ID..." value="" />
            </label>
            <div class="flex gap-2">
              <div class="relative">
                <select
                  class="h-12 pl-4 pr-10 rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary appearance-none cursor-pointer min-w-[160px]">
                  <option value="">Status: All</option>
                  <option value="active">Active</option>
                  <option value="pending">Pending</option>
                  <option value="inactive">Inactive</option>
                </select>
                <span
                  class="material-symbols-outlined absolute right-3 top-3.5 text-[#617589] pointer-events-none !text-xl">expand_more</span>
              </div>
              <button
                class="h-12 w-12 flex items-center justify-center rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] text-[#111418] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                title="More filters">
                <span class="material-symbols-outlined">tune</span>
              </button>
            </div>
          </div>
          <button
            class="flex items-center justify-center overflow-hidden rounded-lg h-12 bg-white dark:bg-[#1a2632] border border-[#dbe0e6] dark:border-gray-600 text-[#111418] dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 gap-2 text-sm font-bold leading-normal tracking-[0.015em] px-4 transition-colors">
            <span class="material-symbols-outlined !text-lg">download</span>
            <span class="truncate">Export CSV</span>
          </button>
        </div>
        <!-- Client List Table -->
        <div
          class="overflow-x-auto rounded-b-xl border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22]">
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
              <!-- Row 1 -->
              <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <div
                      class="h-10 w-10 flex-shrink-0 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-primary font-bold text-lg">
                      A
                    </div>
                    <div>
                      <div class="text-sm font-bold text-[#111418] dark:text-white">Acme Corporation</div>
                      <div class="text-xs text-[#617589] dark:text-gray-400">ID: #CL-0024</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-[#111418] dark:text-white">Sarah Connor</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">sarah@acmecorp.com</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-[#111418] dark:text-white">Los Angeles, CA</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">1024 SkyNet Blvd</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                      title="Edit">
                      <span class="material-symbols-outlined !text-lg">edit</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                      title="Delete">
                      <span class="material-symbols-outlined !text-lg">delete</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white transition-colors"
                      title="View Details">
                      <span class="material-symbols-outlined !text-lg">chevron_right</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 2 -->
              <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <div
                      class="h-10 w-10 flex-shrink-0 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 font-bold text-lg">
                      G
                    </div>
                    <div>
                      <div class="text-sm font-bold text-[#111418] dark:text-white">Globex Inc.</div>
                      <div class="text-xs text-[#617589] dark:text-gray-400">ID: #CL-0089</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-[#111418] dark:text-white">Hank Scorpio</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">hank@globex.com</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-[#111418] dark:text-white">Cypress Creek, OR</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">555 Volacano Lair</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center gap-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                      title="Edit">
                      <span class="material-symbols-outlined !text-lg">edit</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                      title="Delete">
                      <span class="material-symbols-outlined !text-lg">delete</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white transition-colors"
                      title="View Details">
                      <span class="material-symbols-outlined !text-lg">chevron_right</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 3 -->
              <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <div
                      class="h-10 w-10 flex-shrink-0 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 font-bold text-lg">
                      S
                    </div>
                    <div>
                      <div class="text-sm font-bold text-[#111418] dark:text-white">Stark Industries</div>
                      <div class="text-xs text-[#617589] dark:text-gray-400">ID: #CL-0101</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-[#111418] dark:text-white">Pepper Potts</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">ceo@stark.com</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-[#111418] dark:text-white">New York, NY</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">890 Fifth Avenue</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center gap-1 rounded-full bg-amber-50 dark:bg-amber-900/20 px-2 py-1 text-xs font-semibold text-amber-700 dark:text-amber-400 border border-amber-100 dark:border-amber-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Pending Review
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                      title="Edit">
                      <span class="material-symbols-outlined !text-lg">edit</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                      title="Delete">
                      <span class="material-symbols-outlined !text-lg">delete</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white transition-colors"
                      title="View Details">
                      <span class="material-symbols-outlined !text-lg">chevron_right</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 4 -->
              <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-3">
                    <div
                      class="h-10 w-10 flex-shrink-0 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold text-lg">
                      M
                    </div>
                    <div>
                      <div class="text-sm font-bold text-[#111418] dark:text-white">Massive Dynamic</div>
                      <div class="text-xs text-[#617589] dark:text-gray-400">ID: #CL-0542</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-[#111418] dark:text-white">Nina Sharp</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">nina@massivedynamic.com</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-[#111418] dark:text-white">New York, NY</div>
                  <div class="text-xs text-[#617589] dark:text-gray-400">601 Lexington Ave</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span> Inactive
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 text-[#617589] hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors"
                      title="Edit">
                      <span class="material-symbols-outlined !text-lg">edit</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                      title="Delete">
                      <span class="material-symbols-outlined !text-lg">delete</span>
                    </button>
                    <button
                      class="p-2 text-[#617589] hover:text-[#111418] dark:text-gray-400 dark:hover:text-white transition-colors"
                      title="View Details">
                      <span class="material-symbols-outlined !text-lg">chevron_right</span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div
          class="flex items-center justify-between border-t border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22] px-4 py-3 sm:px-6 rounded-b-lg mt-1">
          <div class="hidden sm:flex flex-1 sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-[#617589] dark:text-gray-400">
                Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span
                  class="font-medium">24</span> results
              </p>
            </div>
            <div>
              <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                <a class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                  href="#">
                  <span class="sr-only">Previous</span>
                  <span class="material-symbols-outlined !text-sm">chevron_left</span>
                </a>
                <a aria-current="page"
                  class="relative z-10 inline-flex items-center bg-primary px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                  href="#">1</a>
                <a class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-[#111418] dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                  href="#">2</a>
                <a class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-[#111418] dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                  href="#">3</a>
                <span
                  class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:outline-offset-0">...</span>
                <a class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 focus:z-20 focus:outline-offset-0"
                  href="#">
                  <span class="sr-only">Next</span>
                  <span class="material-symbols-outlined !text-sm">chevron_right</span>
                </a>
              </nav>
            </div>
          </div>
          <!-- Mobile Pagination -->
          <div class="flex flex-1 justify-between sm:hidden">
            <a class="relative inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#1a2632] px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800"
              href="#">Previous</a>
            <a class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#1a2632] px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800"
              href="#">Next</a>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection