@extends('layouts.app')
@section('title','Evaluation Report Export')
@section('content')
<!-- Main Content Layout -->
<div class="flex-1 flex flex-col w-full max-w-[1440px] mx-auto px-4 md:px-10 py-6 pb-24">
  <!-- Breadcrumbs -->
  <div class="flex flex-wrap gap-2 py-2 mb-4">
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary" href="{{ route('admin.screen') }}">Home</a>
    <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary"
      href="{{ route('projects.screen') }}">Projects</a>
    <span class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal">/</span>
    <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary"
      href="{{ route('projects.getEvaluationsId', $project) }}">Project
      {{ old('project_id', $project->project_id) }}</a>
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
          <p class="text-[#111418] dark:text-white text-2xl font-bold leading-tight">
            {{ number_format(old('total_score', $project->judgment->total_score), 1)}}%</p>
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
            <input id="report-title"
              class="w-full bg-[#f6f7f8] dark:bg-[#101922] border border-[#dbe0e6] dark:border-[#2a3441] rounded-lg px-4 py-2.5 text-sm text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all"
              type="text" placeholder="Safety &amp; Compliance Audit - Q3" />
          </div>
          @php
          $defaultTitle = 'Evaluation Report - Project ' . $project->project_name;
          @endphp
          <!-- Input Group -->
          <div class="flex flex-col gap-2">
            <label class="text-[#111418] dark:text-white text-sm font-medium">Prepared For</label>
            <input
              class="w-full bg-[#f6f7f8] dark:bg-[#101922] border border-[#dbe0e6] dark:border-[#2a3441] rounded-lg px-4 py-2.5 text-sm text-[#111418] dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all"
              type="text" value="{{ old('client_name', $project->client->client_name)}}" />
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
            <input checked class="peer sr-only" name="format" type="radio" value="pdf" />
            <div
              class="flex flex-col items-center justify-center p-4 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] bg-[#f6f7f8] dark:bg-[#101922] peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
              <span class="material-symbols-outlined text-3xl mb-2 text-primary">picture_as_pdf</span>
              <span class="text-sm font-bold text-[#111418] dark:text-white">PDF</span>
            </div>
          </label>
          <label class="flex-1 cursor-pointer">
            <input class="peer sr-only" name="format" type="radio" value="csv" />
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
      <div id="preview-badge"
        class="absolute top-4 left-4 bg-black/70 backdrop-blur-md text-white px-3 py-1 rounded text-xs font-medium z-10 flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">visibility</span> Preview Mode
      </div>
      <!-- Paper Sheet (Simulated PDF) -->
      <!-- Use 'text-black' explicitly here as this is a paper preview and should look like ink on paper regardless of app theme -->
      <div id="pdf-preview"
        class="bg-white text-black shadow-2xl w-full max-w-[700px] aspect-[1/1.41] p-8 md:p-12 flex flex-col gap-6 relative origin-top transform scale-100 transition-transform">
        <!-- PDF Header -->
        <div class="flex justify-between items-start border-b-2 border-primary pb-6">
          <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900" id="preview-title">{{ $defaultTitle }}
            </h2>
            <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold">Project
              {{ old('project_name', $project->project_name)}} - Client
              {{ old('client_name', $project->client->client_name)}}
            </p>
          </div>
          <div class="text-right flex flex-col items-end">
            <div class="size-10 bg-gray-900 text-white flex items-center justify-center rounded mb-2">
              <span class="font-bold text-xl">E</span>
            </div>
            <p class="text-xs text-gray-400">Date:
              {{ old('end_date', \Carbon\Carbon::parse($project->end_date)->format('M d, Y'))}}</p>
            <p class="text-xs text-gray-400">Ref: #EVAL-2938</p>
          </div>
        </div>
        <!-- Executive Summary Section -->
        <div class="flex flex-col gap-3">
          <h3 class="text-sm font-bold uppercase text-primary border-b border-gray-100 pb-1">Executive Summary</h3>
          <p class="text-xs leading-relaxed text-gray-600">
            {{ old('evaluator_notes', $project->judgment)}}
          </p>
        </div>
        <!-- Score Visualization (Mock) -->

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
              @foreach($project->judgment->details as $index => $detail)
              @php
              $score = $detail->criteria_point;
              if ($score > 5) {
              $status = 'PASS';
              $badge = 'bg-green-100 text-green-700';
              } elseif ($score == 5) {
              $status = 'WARN';
              $badge = 'bg-orange-100 text-orange-700';
              } else {
              $status = 'FAIL';
              $badge = 'bg-red-100 text-red-700';
              }
              @endphp
              <tr class="border-b border-gray-50">
                <td class="py-2">{{ $detail->criteriaId }}</td>
                <td class="py-2">{{ $detail->criteria_name }}</td>
                <td class="py-2">
                  <span class="{{ $badge }} px-1.5 py-0.5 rounded text-[10px] font-bold">
                    {{ $status }}
                  </span>
                </td>
                <td class="py-2 text-right">
                  {{ $score }}/{{ $detail->criteria_percentage ?? 10 }}%
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- Gradient overlay to signify continuation -->
          <div id="pdf-gradient" class="h-20 w-full bg-gradient-to-t from-white to-transparent -mt-20 z-10 relative">
          </div>
        </div>
        <!-- PDF Footer -->
        <div class="mt-auto border-t border-gray-100 pt-4 flex justify-between items-center text-[10px] text-gray-400">
          <p>Generated by Evaluation Manager Platform</p>
          <p>Page 1</p>
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
      <span>Exporting 14 pages </span>
    </div>
    <div class="flex items-center gap-3 w-full md:w-auto">
      <a href="{{ route('projects.getEvaluationsId', $project) }}"
        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] text-[#111418] dark:text-white font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
        Cancel
      </a>
      <button
        class="flex-1 md:flex-none px-6 py-2.5 rounded-lg border border-[#dbe0e6] dark:border-[#2a3441] text-[#111418] dark:text-white font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-[18px]">mail</span>
        Email
      </button>
      <button id="export-btn" onclick="handleExport()"
        class="flex-[2] md:flex-none px-8 py-2.5 rounded-lg bg-primary text-white font-bold text-sm hover:bg-blue-600 transition-colors shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
        <span id="export-icon" class="material-symbols-outlined text-[18px]">download</span>
        <span id="export-text">Download PDF</span>
      </button>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
const formatRadios = document.querySelectorAll('input[name="format"]');
const exportText = document.getElementById('export-text');
const exportIcon = document.getElementById('export-icon');

formatRadios.forEach(radio => {
  radio.addEventListener('change', () => {
    if (radio.value === 'csv') {
      exportText.innerText = 'Export CSV';
      exportIcon.innerText = 'table_view';
    } else {
      exportText.innerText = 'Download PDF';
      exportIcon.innerText = 'download';
    }
  });
});
document.getElementById('report-title').addEventListener('input', function() {
  const value = this.value.trim();
  document.getElementById('preview-title').innerText =
    value !== '' ? value : @json($defaultTitle);
});

function handleExport() {
  const selected = document.querySelector('input[name="format"]:checked').value;

  if (selected === 'csv') {
    window.location.href = "{{ route('projects.exportCsv', $project) }}";
  } else {
    exportPDF();
  }
}

function exportPDF() {
  const element = document.getElementById('pdf-preview');
  const titleInput = document.getElementById('report-title');
  const reportTitle = titleInput.value.trim() || @json($defaultTitle);
  // Hide elements not suitable for PDF
  document.getElementById('preview-badge')?.style.setProperty('display', 'none');
  document.getElementById('pdf-gradient')?.style.setProperty('display', 'none');

  html2pdf()
    .set({
      margin: [20, 15, 20, 15],
      filename: reportTitle.replace(/[^\w\d]+/g, '_') + '_{{ $project->project_id }}.pdf',
      image: {
        type: 'jpeg',
        quality: 0.98
      },
      html2canvas: {
        scale: 2,
        useCORS: true,
        scrollY: 0
      },
      jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
      }
    })
    .from(document.getElementById('pdf-preview'))
    .save()
    .then(() => {
      // Restore UI
      document.getElementById('preview-badge')?.style.removeProperty('display');
      document.getElementById('pdf-gradient')?.style.removeProperty('display');
    });
}
</script>

@endsection