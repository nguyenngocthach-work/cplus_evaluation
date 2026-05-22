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

.header {
    text-align: center;
    margin-bottom: 20px;
}

.title {
    font-size: 18px;
    font-weight: bold;
}

.subtitle {
    font-size: 14px;
    margin-top: 5px;
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
}

th {
    background: #f2f2f2;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

.parent-row {
    background: #e9f2ff;
    font-weight: bold;
}

.child-row td:first-child {
    padding-left: 20px;
}

.total-row {
    font-weight: bold;
    font-size: 14px;
    border-top: 2px solid #000;
}

/* Top summary card copied from web style */
.summary-card-wrap { width: 100%; margin: 8px 0 12px; }
.summary-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px;
    background: #fff;
    text-align: center;
}
.score-ring-container {
    width: 100px;
    height: 100px;
    margin: 8px auto 4px;
    text-align: center;
    position: relative;
}
.score-label {
    position: absolute;
    top: 35;
    left: 0;
    width: 100px;
    text-align: center;
    z-index: 10;
}
.loc-name { font-weight: bold; font-size: 13px; margin: 4px 0 2px; }
.loc-meta { font-size: 10px; color: #9ca3af; }
.mini-bar-row { margin-top: 8px; text-align: left; }
.bar-label { font-size: 10px; color: #6b7280; margin-bottom: 2px; display: block; }
.bar-outer { width: 100%; height: 6px; background: #e5e7eb; border-radius: 3px; }
.bar-inner { height: 6px; border-radius: 3px; }

.footer {
    margin-top: 40px;
    font-size: 10px;
    color: #666;
}
</style>
</head>

<body>

{{-- HEADER --}}
<div class="header">
    <div class="title">SITE LOCATION EVALUATION RESULT</div>
    <div class="subtitle">Project: {{ $project->project_name }}</div>
    <div class="subtitle">Location: {{ $industry->industry_name }}</div>
</div>

{{-- ===== TOP SUMMARY CARD (Web UI style) ===== --}}
@php
    $ringColor = '#3b82f6';
    $locTotal  = $locationScore['total'];
    $pctTotal  = min(100, $locTotal);
    $stroke    = 251.33;
    $dash      = $stroke * $pctTotal / 100;
@endphp

<div class="summary-card-wrap">
    <div class="summary-card">
        <div class="score-ring-container">
            @if(!empty($ringPath) && file_exists($ringPath))
                <img src="{{ $ringPath }}" width="100" height="100" style="display:block;margin:10px auto 0;">
            @endif
            <div class="score-label">
                <div style="font-size:20px;font-weight:900;color:{{ $ringColor }};line-height:1;">{{ $locTotal }}</div>
                <div style="font-size:10px;color:#9ca3af;line-height:1;">/100</div>
            </div>
        </div>

        <div class="loc-name">{{ $industry->industry_name }}</div>
        <div class="loc-meta">{{ count($locationScore['parents']) }} criteria evaluated</div>

        <div class="mini-bar-row">
        @foreach($locationScore['parents'] as $parent)
            <div style="margin-bottom:5px;">
                <div class="bar-label">{{ $parent['name'] }} &nbsp; {{ $parent['score'] }}/{{ $parent['maxScore'] }}</div>
                <div class="bar-outer">
                    <div class="bar-inner" style="width:{{ $parent['pct'] }}%;background:{{ $ringColor }}"></div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>

{{-- SCORE TABLE --}}
<div class="section-title">Detailed Scoring</div>

@if(!empty($locationRadarPath) && file_exists($locationRadarPath))
<div class="section-title">Spider / Radar Chart</div>
<div style="text-align:center; margin-bottom: 12px;">
    <img src="{{ $locationRadarPath }}" width="450">
</div>
@endif

<table>
    <thead>
        <tr>
            <th width="60%">Criterion</th>
            <th width="20%">Score</th>
            <th width="20%">Max</th>
        </tr>
    </thead>
    <tbody>

    @foreach($locationScore['parents'] as $parent)
        <tr class="parent-row">
            <td>{{ $parent['name'] }}</td>
            <td>{{ $parent['score'] }}</td>
            <td>{{ $parent['maxScore'] }}</td>
        </tr>

        @foreach($parent['children'] as $child)
            <tr class="child-row">
                <td>
                    └ {{ $child['name'] }}
                    @if($child['value'])
                        ({{ $child['value'] }})
                    @endif
                </td>
                <td>{{ $child['score'] }}</td>
                <td>{{ $child['maxScore'] }}</td>
            </tr>
        @endforeach
    @endforeach

    <tr class="total-row">
        <td>TOTAL SCORE</td>
        <td>{{ $locationScore['total'] }}</td>
        <td>100</td>
    </tr>

    </tbody>
</table>

<div class="footer">
    <p>
        Disclaimer:<br>
        This evaluation result is calculated based on predefined criteria
        and weighted scoring agreed upon by the client.
        We assume no legal responsibility for decisions made based on this document.
    </p>
</div>

</body>
</html>
