@extends('layouts.app')
@section('title','Project Detail')
@section('content')
<h3>Project Evaluation</h3>
<canvas id="radarChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/radar-chart.js') }}"></script>
<script>
renderRadarChart(@json($criteriaLabels), @json($criteriaScores));
</script>
@endsection
