@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
<div class="flex h-screen w-full flex-row overflow-hidden">
  <!-- Main Content Area -->
  <main class="flex-1 flex flex-col h-full overflow-hidden bg-background-light dark:bg-background-dark relative">
    <!-- Top Header -->
    <header
      class="flex items-center justify-between whitespace-nowrap border-b border-[#e5e7eb] dark:border-[#2a3441] bg-white dark:bg-[#1a202c] px-8 py-4 shrink-0">
      <div class="flex items-center gap-4">
        <button class="lg:hidden p-2 text-[#617589]">
          <span class="material-symbols-outlined">menu</span>
        </button>
        <h2 class="text-[#111418] dark:text-white text-xl font-bold leading-tight tracking-tight">Dashboard Overview
        </h2>
      </div>
      <div class="flex items-center gap-6">
        <div class="hidden md:flex relative w-64">
          <span
            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#617589] dark:text-[#9ca3af]"
            style="font-size: 20px;">search</span>
          <input
            class="w-full pl-10 pr-4 py-2 bg-[#f0f2f4] dark:bg-[#2d3748] border-none rounded-lg text-sm text-[#111418] dark:text-white focus:ring-2 focus:ring-primary placeholder:text-[#617589]"
            placeholder="Search..." type="text" />
        </div>
        <button class="relative p-2 text-[#617589] dark:text-[#9ca3af] hover:text-primary transition-colors">
          <span class="material-symbols-outlined">notifications</span>
          <span
            class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white dark:border-[#1a202c]"></span>
        </button>
      </div>
    </header>
    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-4 md:p-8">
      <div class="max-w-[1200px] mx-auto flex flex-col gap-8">
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
            <h1 class="text-[#111418] dark:text-white text-2xl md:text-3xl font-bold">Welcome back, Administrator</h1>
            <p class="text-[#617589] dark:text-[#9ca3af] text-sm mt-1">Here is an overview of your active projects and
              evaluations.</p>
          </div>
          <div class="flex gap-3">
            <button
              class="bg-white dark:bg-[#2d3748] border border-[#e5e7eb] dark:border-[#4a5568] text-[#111418] dark:text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-[#4a5568] transition flex items-center gap-2">
              <span class="material-symbols-outlined text-sm">download</span> Export
            </button>
            <a href="{{ route('projects.create.screen') }}"
              class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-blue-600 transition flex items-center gap-2">
              <span class="material-symbols-outlined text-sm">add</span> New Project
            </a>
          </div>
        </div>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div
            class="bg-white dark:bg-[#1a202c] rounded-xl p-5 border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
              <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                <span class="material-symbols-outlined text-primary">groups</span>
              </div>
              <span
                class="flex items-center text-[#078838] bg-[#ecfdf3] dark:bg-[#078838]/20 px-2 py-1 rounded text-xs font-bold">
                <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +12%
              </span>
            </div>
            <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-medium">Total Clients</p>
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">{{ $totalClients }}</p>
          </div>
          <div
            class="bg-white dark:bg-[#1a202c] rounded-xl p-5 border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
              <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">location_on</span>
              </div>
              <span class="text-[#617589] dark:text-[#9ca3af] text-xs font-bold px-2 py-1">0%</span>
            </div>
            <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-medium">Active Locations</p>
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">{{ $totalLocation }}</p>
          </div>
          <div
            class="bg-white dark:bg-[#1a202c] rounded-xl p-5 border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
              <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">work</span>
              </div>
              <span
                class="flex items-center text-[#078838] bg-[#ecfdf3] dark:bg-[#078838]/20 px-2 py-1 rounded text-xs font-bold">
                <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +5%
              </span>
            </div>
            <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-medium">Ongoing Projects</p>
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">{{ $totalProject }}</p>
          </div>
          <div
            class="bg-white dark:bg-[#1a202c] rounded-xl p-5 border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
              <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">assignment_late</span>
              </div>
              <span
                class="flex items-center text-[#e73908] bg-[#fff0ed] dark:bg-[#e73908]/20 px-2 py-1 rounded text-xs font-bold">
                <span class="material-symbols-outlined text-sm mr-1">trending_down</span> -2%
              </span>
            </div>
            <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-medium">Pending Evaluations</p>
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">3</p>
          </div>
        </div>
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <a href="{{ route('clients.create.screen') }}"
            class="flex items-center gap-4 p-4 bg-white dark:bg-[#1a202c] border border-[#e5e7eb] dark:border-[#2a3441] rounded-xl hover:border-primary/50 hover:shadow-md transition-all group text-left">
            <div
              class="size-12 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors text-primary">
              <span class="material-symbols-outlined">person_add</span>
            </div>
            <div>
              <h3 class="font-bold text-[#111418] dark:text-white">Register Client</h3>
              <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Onboard a new client</p>
            </div>
          </a>
          <a href="{{ route('locations.create.screen') }}"
            class="flex items-center gap-4 p-4 bg-white dark:bg-[#1a202c] border border-[#e5e7eb] dark:border-[#2a3441] rounded-xl hover:border-primary/50 hover:shadow-md transition-all group text-left">
            <div
              class="size-12 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors text-primary">
              <span class="material-symbols-outlined">add_location_alt</span>
            </div>
            <div>
              <h3 class="font-bold text-[#111418] dark:text-white">Add Location</h3>
              <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Create new site entry</p>
            </div>
          </a>
          <button type="button" onclick="openEvaluationModal()"
            class="flex items-center gap-4 p-4 bg-white dark:bg-[#1a202c] border border-[#e5e7eb] dark:border-[#2a3441] rounded-xl hover:border-primary/50 hover:shadow-md transition-all group text-left">
            <div
              class="size-12 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors text-primary">
              <span class="material-symbols-outlined">playlist_add</span>
            </div>
            <div>
              <h3 class="font-bold text-[#111418] dark:text-white">Start Evaluation</h3>
              <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Begin new assessment</p>
            </div>
          </button>
        </div>
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Active Projects Table -->
          <div
            class="lg:col-span-2 bg-white dark:bg-[#1a202c] rounded-xl border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-[#e5e7eb] dark:border-[#2a3441] flex justify-between items-center">
              <h3 class="text-lg font-bold text-[#111418] dark:text-white">Active Projects</h3>
              <a class="text-sm font-bold text-primary hover:text-blue-700" href="{{ route('projects.screen') }}">View
                All</a>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-[#f8fafc] dark:bg-[#2d3748]">
                    <th class="p-4 text-xs font-semibold text-[#617589] dark:text-[#9ca3af] uppercase tracking-wider">
                      Project Name</th>
                    <th class="p-4 text-xs font-semibold text-[#617589] dark:text-[#9ca3af] uppercase tracking-wider">
                      Client</th>
                    <th class="p-4 text-xs font-semibold text-[#617589] dark:text-[#9ca3af] uppercase tracking-wider">
                      Status</th>
                    <th class="p-4 text-xs font-semibold text-[#617589] dark:text-[#9ca3af] uppercase tracking-wider">
                      Progress</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-[#e5e7eb] dark:divide-[#2a3441]">
                  @php
                  $statusMap = [
                  0 => [
                  'label' => 'On Hold',
                  'badge' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                  'progress' => 0,
                  'bar' => 'bg-gray-400'
                  ],
                  1 => [
                  'label' => 'In Progress',
                  'badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200',
                  'progress' => 25,
                  'bar' => 'bg-primary'
                  ],
                  2 => [
                  'label' => 'Pending Review',
                  'badge' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200',
                  'progress' => 50,
                  'bar' => 'bg-yellow-500'
                  ],
                  3 => [
                  'label' => 'Progressing',
                  'badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200',
                  'progress' => 75,
                  'bar' => 'bg-primary'
                  ],
                  4 => [
                  'label' => 'Success',
                  'badge' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200',
                  'progress' => 100,
                  'bar' => 'bg-green-500'
                  ],
                  5 => [
                  'label' => 'Reject',
                  'badge' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200',
                  'progress' => 100,
                  'bar' => 'bg-red-500'
                  ],
                  ];
                  @endphp
                  @forelse($activeProjectList as $projectList)
                  @php
                  $status = $statusMap[$projectList->status] ?? $statusMap[0];
                  @endphp
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">
                        {{ $projectList->project_name ?? '-' }}
                      </div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due:
                        {{ \Carbon\Carbon::parse($projectList->end_date)->format('M d, Y') }}</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">
                      {{ $projectList->client->client_name ?? '-' }}</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200 {{ $status['badge'] }}">
                        {{ $status['label'] }}
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="{{ $status['bar'] }} h-1.5 rounded-full"
                            style="width: {{ $status['progress'] }}%">
                          </div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">
                          {{ $status['progress'] }}%
                        </span>
                      </div>
                    </td>
                    @empty
                  <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                      No projects found.
                    </td>
                  </tr>
                  @endforelse
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Recent Activity Feed -->
          <div
            class="bg-white dark:bg-[#1a202c] rounded-xl border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm flex flex-col h-full">
            <div class="p-5 border-b border-[#e5e7eb] dark:border-[#2a3441]">
              <h3 class="text-lg font-bold text-[#111418] dark:text-white">Recent Activity</h3>
            </div>
            <div class="p-5 flex-1 overflow-y-auto">
              <ul class="space-y-6">
                <li class="relative pl-6 border-l-2 border-[#e5e7eb] dark:border-[#2a3441] pb-1">
                  <div
                    class="absolute -left-[9px] top-0 size-4 rounded-full bg-blue-100 dark:bg-blue-900 border-2 border-white dark:border-[#1a202c]">
                    <div class="size-2 bg-primary rounded-full m-[2px]"></div>
                  </div>
                  <div class="flex flex-col gap-1">
                    <p class="text-sm text-[#111418] dark:text-white font-medium">New location added</p>
                    <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Admin User added "Austin HQ"</p>
                    <span class="text-xs text-[#9ca3af] dark:text-[#617589]">2 hours ago</span>
                  </div>
                </li>
                <li class="relative pl-6 border-l-2 border-[#e5e7eb] dark:border-[#2a3441] pb-1">
                  <div
                    class="absolute -left-[9px] top-0 size-4 rounded-full bg-green-100 dark:bg-green-900 border-2 border-white dark:border-[#1a202c]">
                    <div class="size-2 bg-green-500 rounded-full m-[2px]"></div>
                  </div>
                  <div class="flex flex-col gap-1">
                    <p class="text-sm text-[#111418] dark:text-white font-medium">Project Completed</p>
                    <p class="text-xs text-[#617589] dark:text-[#9ca3af]">"Q2 Financials" marked complete</p>
                    <span class="text-xs text-[#9ca3af] dark:text-[#617589]">5 hours ago</span>
                  </div>
                </li>
                <li class="relative pl-6 border-l-2 border-[#e5e7eb] dark:border-[#2a3441] pb-1">
                  <div
                    class="absolute -left-[9px] top-0 size-4 rounded-full bg-yellow-100 dark:bg-yellow-900 border-2 border-white dark:border-[#1a202c]">
                    <div class="size-2 bg-yellow-500 rounded-full m-[2px]"></div>
                  </div>
                  <div class="flex flex-col gap-1">
                    <p class="text-sm text-[#111418] dark:text-white font-medium">Evaluation Flagged</p>
                    <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Review pending for Site #4</p>
                    <span class="text-xs text-[#9ca3af] dark:text-[#617589]">1 day ago</span>
                  </div>
                </li>
                <li class="relative pl-6 border-l-2 border-[#e5e7eb] dark:border-[#2a3441] pb-1">
                  <div
                    class="absolute -left-[9px] top-0 size-4 rounded-full bg-gray-100 dark:bg-gray-800 border-2 border-white dark:border-[#1a202c]">
                    <div class="size-2 bg-gray-400 rounded-full m-[2px]"></div>
                  </div>
                  <div class="flex flex-col gap-1">
                    <p class="text-sm text-[#111418] dark:text-white font-medium">Client Updated</p>
                    <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Contact info changed for Acme Corp</p>
                    <span class="text-xs text-[#9ca3af] dark:text-[#617589]">2 days ago</span>
                  </div>
                </li>
              </ul>
            </div>
            <div class="p-4 border-t border-[#e5e7eb] dark:border-[#2a3441]">
              <button class="w-full text-center text-sm font-bold text-primary hover:text-blue-700">View All
                Activity</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <footer class="mt-12 mb-6 text-center">
        <p class="text-xs text-[#617589] dark:text-[#9ca3af]">© 2023 Admin Console System. All rights reserved.</p>
      </footer>
    </div>
  </main>
  <!-- Start Evaluation Modal -->
  <div id="evaluationModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-[#1a202c] w-full max-w-lg rounded-xl shadow-lg p-6">
      <h3 class="text-lg font-bold mb-4 text-[#111418] dark:text-white">
        Start Evaluation
      </h3>
      <form method="GET" action="{{ route('evaluations.create.screen') }}">
        <label class="block text-sm font-medium mb-2 text-[#617589]">
          Select Project
        </label>

        <select id="projectSelect"
                required
                class="w-full border rounded-lg px-3 py-2 text-sm">
          <option value="">-- Choose project --</option>

          @foreach($activeProjectList as $project)
            <option value="{{ $project->project_id }}">
              {{ $project->project_name }}
            </option>
          @endforeach
        </select>

        <div class="flex justify-end gap-3 mt-6">
          <button type="button"
                  onclick="closeEvaluationModal()"
                  class="px-4 py-2 text-sm rounded-lg border">
            Cancel
          </button>

          <button type="button" onclick="startEvaluation()"
                  class="px-4 py-2 text-sm rounded-lg bg-primary text-white">
            Start
          </button>
        </div>
      </form>
    </div>
  </div>

</div>
<script>
  function openEvaluationModal() {
    document.getElementById('evaluationModal').classList.remove('hidden')
    document.getElementById('evaluationModal').classList.add('flex')
  }

  function closeEvaluationModal() {
    document.getElementById('evaluationModal').classList.add('hidden')
    document.getElementById('evaluationModal').classList.remove('flex')
  }

  function startEvaluation() {
    const projectId = document.getElementById('projectSelect').value;

    if (!projectId) {
      alert('Please select a project');
      return;
    }

    window.location.href = `/projects/${projectId}/evaluations`;
  }
</script>

@endsection