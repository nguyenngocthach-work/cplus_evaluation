@extends('layouts.app')
@section('title','Manage Projects')
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
            href="{{ route('admin.screen') }}">Dashboard</a>
          <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
          <span class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Projects</span>
        </div>
        <!-- Page Heading & Actions -->
        <div class="flex flex-col md:flex-row justify-between gap-6 p-4 items-start md:items-center">
          <div class="flex min-w-72 flex-col gap-2">
            <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Manage
              Projects</h1>
            <p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">View and manage your
              projects list, locations, and details.</p>
          </div>
          <a href="{{ route('projects.create.screen') }}"
            class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white hover:bg-blue-600 transition-colors text-sm font-bold leading-normal tracking-[0.015em] shadow-sm">
            <span class="material-symbols-outlined mr-2 !text-lg">add</span>
            <span class="truncate">Add New Project</span>
          </a>
        </div>
        <!-- Toolbar / Filters -->
        <form method="GET" action="{{ route('projects.screen') }}">
          <div
            class="flex flex-col md:flex-row justify-between gap-4 px-4 py-4 bg-white dark:bg-[#111a22] rounded-t-xl border-x border-t border-[#dbe0e6] dark:border-gray-700 mt-4">
            <div class="flex flex-1 gap-4 flex-col md:flex-row">
              <label class="flex flex-col min-w-40 flex-1 max-w-md relative group">
                <span class="material-symbols-outlined absolute left-4 top-3.5 text-[#617589]">search</span>
                <input name="keyword" value="{{ request('keyword') }}"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-[#1a2632] focus:border-primary h-12 placeholder:text-[#617589] pl-12 pr-4 text-sm font-normal leading-normal transition-all"
                  placeholder="Search project by name" value="" />
              </label>
            </div>
            <button type="submit" class="h-12 px-4 rounded-lg border border-[#dbe0e6] dark:border-gray-600
              bg-white dark:bg-[#1a2632] text-sm hover:bg-gray-50 dark:hover:bg-gray-800">
              Filter
            </button>
        </form>
        <a href="{{ route('clients.export', request()->query()) }}"
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
                Project Name</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Client Name</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Location</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Start Date</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                End Date</th>
              <th
                class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#617589] dark:text-gray-400">
                Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#dbe0e6] dark:divide-gray-700">
            <!-- Row 1 -->
            @forelse($projects as $project)
            <tr class="group hover:bg-gray-50 dark:hover:bg-[#1f2b37] transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="text-sm font-bold text-[#111418] dark:text-white">{{ $project->project_name }}</div>
                    <div class="text-xs text-[#617589] dark:text-gray-400">ID: {{ $project->id }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-[#111418] dark:text-white">
                  <div class="text-sm font-medium text-[#111418] dark:text-white">
                    {{ $project->client->client_name ?? '-' }}
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[#111418] dark:text-white">
                  {{ $project->industry->industry_name ?? '-' }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[#111418] dark:text-white">
                  {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[#111418] dark:text-white">
                  {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}
                </div>
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
            @empty
            <tr>
              <td colspan="5" class="text-center py-6 text-gray-500">
                No project found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div
        class="border flex items-center justify-between border-t border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-[#111a22] px-4 py-3 sm:px-6 rounded-b-lg mt-1">
        <div class="hidden sm:flex flex-1 sm:items-center sm:justify-between">
          <div class="mt-4 flex justify-end">
            {{ $projects->withQueryString()->links() }}
          </div>
        </div>
      </div>
  </div>
  </main>
</div>
</div>
@endsection