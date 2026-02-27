<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #111;
}

.center { text-align: center; }

.title {
    font-size: 18px;
    font-weight: bold;
}

.subtitle {
    font-size: 13px;
    margin-top: 4px;
}

.section-title {
    font-size: 14px;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 6px;
    border-bottom: 1px solid #ddd;
}

th {
    background: #f2f2f2;
}

.total {
    font-weight: bold;
    font-size: 14px;
}

.image-box {
    margin-top: 10px;
    margin-bottom: 15px;
}

.footer {
    margin-top: 40px;
    font-size: 10px;
    color: #666;
}
</style>
</head>

<body>

{{-- HEADER --}}
<div class="center">
    <div class="title">SITE LOCATIONS EVALUATION RESULT</div>
    <div class="subtitle">Project: {{ $project->project_name }}</div>
    <div class="subtitle">Total Locations: {{ $industries->count() }}</div>
</div>

{{-- RADAR --}}
@if(file_exists($radarPath))
<div class="section-title">Radar Chart</div>
<div class="center">
    <img src="{{ $radarPath }}" width="400">
</div>
@endif

{{-- RANKING --}}
<div class="section-title">Ranking</div>
<table>
    <thead>
        <tr>
            <th width="10%">Rank</th>
            <th width="60%">Location</th>
            <th width="30%">Score</th>
        </tr>
    </thead>
    <tbody>
    @php
        $ranked = collect($scores)->sortByDesc('total')->values();
    @endphp

    @foreach($ranked as $index => $score)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $score['industry_name'] }}</td>
            <td>{{ $score['total'] }} / 100</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- LOCATION DETAILS --}}
@foreach($industries as $industry)

    <div class="section-title">
        {{ $industry->industry_name }}
    </div>

    {{-- Representative Image --}}
    @if(isset($images[$industry->id]) && file_exists($images[$industry->id]))
        <div class="image-box">
            <img src="{{ $images[$industry->id] }}" width="250">
        </div>
    @endif

    {{-- Parent Scores --}}
    <table>
        <thead>
            <tr>
                <th width="70%">Criterion</th>
                <th width="30%">Score</th>
            </tr>
        </thead>
        <tbody>
        @foreach($scores[$industry->id]['parents'] as $parent)
            <tr>
                <td>{{ $parent['name'] }}</td>
                <td>{{ $parent['score'] }} / {{ $parent['maxScore'] }}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td>Total</td>
            <td>{{ $scores[$industry->id]['total'] }} / 100</td>
        </tr>
        </tbody>
    </table>

@endforeach

{{-- DISCLAIMER --}}
<div class="footer">
    <p>
        Disclaimer:<br>
        This document has been created based on various conditions and criteria
        provided by the Client.
        The evaluation results are calculated based on weighted scoring.
        We assume no legal responsibility for decisions made using this report.
    </p>
</div>

</body>
</html>