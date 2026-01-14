@extends('layouts.app')
@section('title','Project Detail')

@push('styles')
<style>
body {
  font-family: 'Manrope', sans-serif;
}

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
<main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-40">
  <div class="w-full max-w-[960px] flex flex-col gap-6">

    <!-- Breadcrumb -->
    <div class="flex flex-wrap gap-2 px-4">
      <a class="text-[#617589] hover:text-primary" href="{{ route('admin.screen') }}">Dashboard</a>
      <span>/</span>
      <a class="text-[#617589] hover:text-primary" href="#">Projects</a>
      <span>/</span>
      <span class="text-[#111418] font-medium">Project Detail</span>
    </div>

    <!-- Header -->
    <div class="flex justify-between items-end px-4">
      <div>
        <h1 class="text-4xl font-black text-[#111418] dark:text-white">
          Project Detail
        </h1>
        <p class="text-[#617589]">
          View project information and evaluation criteria.
        </p>
      </div>

      <div class="flex gap-3">
        @if($project->status < 3) <a href="{{ route('projects.getId', $project) }}"
          class="h-10 px-4 flex items-center bg-primary text-white rounded-lg text-sm font-bold">
          Edit
          </a>
          @endif

          <a href="{{ route('projects.screen') }}"
            class="h-10 px-4 flex items-center border rounded-lg text-sm font-bold">
            Back
          </a>
      </div>
    </div>

    <!-- GENERAL INFO -->
    <div class="bg-white dark:bg-[#1a2632] rounded-xl border shadow-sm">
      <h2 class="px-6 py-5 text-[22px] font-bold border-b">General Information</h2>

      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-2">
          <span class="text-sm text-[#617589]">Project Name</span>
          <p class="font-medium text-[#111418] dark:text-white">
            {{ $project->project_name }}
          </p>
        </div>

        <div class="col-span-2">
          <span class="text-sm text-[#617589]">Description</span>
          <div class="mt-1 bg-gray-50 dark:bg-[#253240] p-4 rounded-lg text-sm">
            {{ $project->description ?? '—' }}
          </div>
        </div>

        <div>
          <span class="text-sm text-[#617589]">Start Date</span>
          <p class="font-medium">
            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '—' }}
          </p>
        </div>

        <div>
          <span class="text-sm text-[#617589]">End Date</span>
          <p class="font-medium">
            {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : '—' }}
          </p>
        </div>
      </div>
    </div>

    <!-- ASSIGNMENTS -->
    <div class="bg-white dark:bg-[#1a2632] rounded-xl border shadow-sm">
      <h2 class="px-6 py-5 text-[22px] font-bold border-b">Assignments</h2>

      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <span class="text-sm text-[#617589]">Client</span><br>
          @if($project->client)
          <span class="inline-block mt-1 bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">
            {{ $project->client->client_name }}
          </span>
          @else
          <span>—</span>
          @endif
        </div>

        <div>
          <span class="text-sm text-[#617589]">Location</span><br>
          @if($project->industry)
          <span class="inline-block mt-1 bg-green-500/10 text-green-600 px-3 py-1 rounded-full text-sm font-medium">
            {{ $project->industry->industry_name }}
          </span>
          @else
          <span>—</span>
          @endif
        </div>
      </div>
    </div>

    <!-- CRITERIA -->
    <div class="bg-white dark:bg-[#1a2632] rounded-xl border shadow-sm">
      <div class="px-6 py-5 border-b">
        <h2 class="text-[22px] font-bold">Evaluation Criteria</h2>
      </div>

      <div class="p-6">
        <div class="hidden md:grid grid-cols-12 gap-4 text-xs font-bold text-[#617589] mb-3">
          <div class="col-span-4">Name</div>
          <div class="col-span-2 text-center">Weight</div>
          <div class="col-span-6">Description</div>
        </div>

        @php $total = 0; @endphp

        @forelse($project->criteria as $c)
        @php $total += $c->pivot->weight; @endphp
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 py-3 border-b text-sm">
          <div class="col-span-4 font-medium">
            {{ $c->criteria_name }}
          </div>
          <div class="col-span-2 text-center">
            {{ $c->pivot->weight }}%
          </div>
          <div class="col-span-6 text-gray-600 dark:text-gray-300">
            {{ $c->pivot->custom_description ?? '—' }}
          </div>
        </div>
        @empty
        <p class="text-center text-gray-500 py-6">No criteria assigned.</p>
        @endforelse

        <div class="mt-4 text-right font-bold">
          Total Weight: {{ $total }}%
        </div>
      </div>
    </div>
  </div>
</main>
@endsection