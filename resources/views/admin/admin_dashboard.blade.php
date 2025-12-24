@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
<div class="flex h-screen w-full flex-row overflow-hidden">
  <!-- Sidebar Navigation -->
  <aside
    class="flex h-full w-72 flex-col justify-between border-r border-[#e5e7eb] dark:border-[#2a3441] bg-white dark:bg-[#1a202c] overflow-y-auto shrink-0 transition-all duration-300">
    <div class="flex flex-col gap-4 p-4">
      <div class="flex gap-3 items-center mb-6">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
          data-alt="Abstract blue geometric logo"
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCRGjEbh3nPkDmPIsyOagergOq0nbi9OTWc8tSsj-qFYiQtpbqnauk0HvRhP9020CD1Nfm_FUqdBdVWX9ScmLEZoyV6HMAvuZnBarUwkhOKj53u3kf8m1YlGaz3utmS3VWLJbvzhBS74Y5jH9DUO49VoDwWYaySlkqyYLRgodSozdJXPpTw6zhPDxTlPRGOyNxjvmG_wKQf4XUaKUzfm3t2BL7jlHr5IoM0unMHM9VKyIKmNIYq2GVQW7J5BQRsYysdWzBur16VjPm5");'>
        </div>
        <div class="flex flex-col">
          <h1 class="text-[#111418] dark:text-white text-base font-bold leading-normal">Admin Console</h1>
          <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-normal leading-normal">Management System</p>
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary" href="#">
          <span class="material-symbols-outlined text-primary">dashboard</span>
          <p class="text-primary text-sm font-bold leading-normal">Dashboard</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#f3f4f6] dark:hover:bg-[#2d3748] transition-colors group"
          href="{{ route('admin.clients.screen') }}">
          <span
            class="material-symbols-outlined text-[#617589] group-hover:text-[#111418] dark:text-[#9ca3af] dark:group-hover:text-white">groups</span>
          <p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Clients</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#f3f4f6] dark:hover:bg-[#2d3748] transition-colors group"
          href="{{ route('admin.locations') }}">
          <span
            class="material-symbols-outlined text-[#617589] group-hover:text-[#111418] dark:text-[#9ca3af] dark:group-hover:text-white">location_on</span>
          <p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Locations</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#f3f4f6] dark:hover:bg-[#2d3748] transition-colors group"
          href="{{ route('admin.projects') }}">
          <span
            class="material-symbols-outlined text-[#617589] group-hover:text-[#111418] dark:text-[#9ca3af] dark:group-hover:text-white">work</span>
          <p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Projects</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#f3f4f6] dark:hover:bg-[#2d3748] transition-colors group"
          href="{{ route('admin.evaluations') }}">
          <span
            class="material-symbols-outlined text-[#617589] group-hover:text-[#111418] dark:text-[#9ca3af] dark:group-hover:text-white">assignment</span>
          <p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Evaluations</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#f3f4f6] dark:hover:bg-[#2d3748] transition-colors group"
          href=" {{ route('admin.reports') }}">
          <span
            class="material-symbols-outlined text-[#617589] group-hover:text-[#111418] dark:text-[#9ca3af] dark:group-hover:text-white">settings</span>
          <p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Reports</p>
        </a>
      </div>
    </div>
    <div class="p-4 border-t border-[#e5e7eb] dark:border-[#2a3441]">
      <div class="flex items-center gap-3">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
          data-alt="Profile picture of administrator"
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCwRgvBtatfWXV_TgbykqA_J4k0uBXcI4o008UlYdazs4bOEfH1wg14pMcoCpjrEMCp08FF7dglAS8V9EMDV-sDx7an0CsRmBwJS47ZotsufskCJtncTyGPTOP_ScL3W_BkpUHBQJOlm8tTWkis1NdEf6ECwi0YgfaVUXCFHnx6nfZUByI8N4kFt0I8RSKo00yWTxAkkUKmiDpX8Y2NzqRAE5viPJZAisiCT_FfFr097EDmivn8QneYX-p-tL4dkNuPLqgT6rlgop1b");'>
        </div>
        <div>
          <p class="text-sm font-bold text-[#111418] dark:text-white">Jane Doe</p>
          <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Super Admin</p>
        </div>
      </div>
    </div>
  </aside>
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
            <a href="{{ route('admin.projects') }}"
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
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">124</p>
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
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">8</p>
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
            <p class="text-[#111418] dark:text-white text-2xl font-bold mt-1">15</p>
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
          <a href="{{ route('admin.clients.screen') }}"
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
          <a href="{{ route('admin.locations') }}"
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
          <a href="{{ route('admin.evaluations') }}"
            class="flex items-center gap-4 p-4 bg-white dark:bg-[#1a202c] border border-[#e5e7eb] dark:border-[#2a3441] rounded-xl hover:border-primary/50 hover:shadow-md transition-all group text-left">
            <div
              class="size-12 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors text-primary">
              <span class="material-symbols-outlined">playlist_add</span>
            </div>
            <div>
              <h3 class="font-bold text-[#111418] dark:text-white">Start Evaluation</h3>
              <p class="text-xs text-[#617589] dark:text-[#9ca3af]">Begin new assessment</p>
            </div>
          </a>
        </div>
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Active Projects Table -->
          <div
            class="lg:col-span-2 bg-white dark:bg-[#1a202c] rounded-xl border border-[#e5e7eb] dark:border-[#2a3441] shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-[#e5e7eb] dark:border-[#2a3441] flex justify-between items-center">
              <h3 class="text-lg font-bold text-[#111418] dark:text-white">Active Projects</h3>
              <a class="text-sm font-bold text-primary hover:text-blue-700" href="#">View All</a>
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
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">Q3 Infrastructure Upgrade</div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due: Oct 24, 2023</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">Acme Corp</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                        In Progress
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="bg-primary h-1.5 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">75%</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">Downtown Office Reno</div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due: Nov 01, 2023</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">Stark Ind.</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200">
                        Pending Review
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 90%"></div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">90%</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">Server Migration - East</div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due: Nov 15, 2023</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">Globex Inc.</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                        In Progress
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="bg-primary h-1.5 rounded-full" style="width: 45%"></div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">45%</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">Mobile App Beta</div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due: Dec 10, 2023</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">Wayne Ent.</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        On Hold
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="bg-gray-400 h-1.5 rounded-full" style="width: 15%"></div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">15%</span>
                      </div>
                    </td>
                  </tr>
                  <tr class="hover:bg-[#f9fafb] dark:hover:bg-[#2d3748]/50 transition-colors">
                    <td class="p-4">
                      <div class="font-bold text-[#111418] dark:text-white">Security Audit</div>
                      <div class="text-xs text-[#617589] dark:text-[#9ca3af]">Due: Dec 22, 2023</div>
                    </td>
                    <td class="p-4 text-sm text-[#111418] dark:text-white">Umbrella Corp</td>
                    <td class="p-4">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                        In Progress
                      </span>
                    </td>
                    <td class="p-4 w-32">
                      <div class="flex items-center gap-2">
                        <div class="w-full bg-[#e5e7eb] dark:bg-[#4a5568] rounded-full h-1.5">
                          <div class="bg-primary h-1.5 rounded-full" style="width: 60%"></div>
                        </div>
                        <span class="text-xs font-medium text-[#617589] dark:text-[#9ca3af]">60%</span>
                      </div>
                    </td>
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
</div>
@endsection