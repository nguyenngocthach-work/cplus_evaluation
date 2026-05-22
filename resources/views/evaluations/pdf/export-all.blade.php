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
.title { font-size: 18px; font-weight: bold; }
.subtitle { font-size: 13px; margin-top: 4px; }
.section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 8px; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 6px; border-bottom: 1px solid #ddd; }
th { background: #f2f2f2; }
.total { font-weight: bold; font-size: 14px; }
.image-box { margin-top: 10px; margin-bottom: 15px; }
.footer { margin-top: 40px; font-size: 10px; color: #666; }

/* Score card grid */
.card-grid { width: 100%; margin: 10px 0; }
.card-grid td { padding: 6px; border: none; vertical-align: top; }
.score-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 10px;
    text-align: center;
    background: #fff;
}
.badge-slot { height: 16px; margin-bottom: 6px; padding-bottom: 8px;}
.winner-badge {
    display: inline-block;
    background: #fbbf24;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 10px;
    border-radius: 12px;
}
.score-ring-container {
    width: 96px;
    height: 96px;
    margin: 8px auto 4px;
    text-align: center;
    position: relative;
}
.score-label {
    position: absolute;
    top: 20px;
    left: 0;
    width: 96px;
    text-align: center;
    z-index: 10;
}
.loc-name { font-weight: bold; font-size: 12px; margin: 3px 0 1px; }
.loc-meta { font-size: 9px; color: #9ca3af; }
.mini-bar-row { margin-top: 6px; text-align: left; }
.bar-label { font-size: 9px; color: #6b7280; margin-bottom: 1px; display: block; }
.bar-outer { width: 100%; height: 5px; background: #e5e7eb; border-radius: 3px; }
.bar-inner { height: 5px; border-radius: 3px; }
.page-break { page-break-before: always; }
.chart-grid { width: 100%; border-collapse: collapse; margin-top: 10px; }
.chart-grid td { width: 50%; padding: 5px; border: none; vertical-align: top; text-align: center; }
.chart-title { font-weight: bold; margin-bottom: 5px; font-size: 11px; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="center">
    <div class="title">SITE LOCATIONS EVALUATION RESULT</div>
    <div class="subtitle">Project: {{ $project->project_name }}</div>
    <div class="subtitle">Total Locations: {{ $industries->count() }}</div>
</div>

{{-- ===== SCORE SUMMARY CARDS (Web UI style) ===== --}}
@php
    $maxTotal = collect($scores)->max('total');
    $palette  = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
    $ci = 0;
    $cardCount = count($scores);
    $cols = min($cardCount, 2);
@endphp

<table class="card-grid">
@foreach($scores as $iid => $iScore)
    @php
        $color    = $palette[$ci % count($palette)];
        $isWinner = $iScore['total'] == $maxTotal;
        $pct      = min(100, $iScore['total']);
        $stroke   = 251.33;
        $dash     = $stroke * $pct / 100;
    @endphp
    @if($ci % $cols == 0)<tr>@endif
        <td>
            <div class="score-card">
                <div class="badge-slot">
                    @if($isWinner)
                        <div class="winner-badge">&#9733; Best</div>
                    @endif
                </div>

                {{-- Ring (server-side PNG) --}}
                <div class="score-ring-container">
                    @if(!empty($ringPaths[$iid]) && file_exists($ringPaths[$iid]))
                        <img src="{{ $ringPaths[$iid] }}" width="88" height="88" style="display:block;margin:6px auto 0;">
                    @endif
                    <div class="score-label">
                        <div style="font-size:20px;font-weight:900;color:{{ $color }};line-height:1;">{{ $iScore['total'] }}</div>
                        <div style="font-size:10px;color:#9ca3af;line-height:1;">/100</div>
                    </div>
                </div>

                <div class="loc-name">{{ $iScore['industry_name'] }}</div>
                <div class="loc-meta">{{ count($iScore['parents']) }} criteria evaluated</div>

                {{-- Mini bars --}}
                <div class="mini-bar-row">
                @foreach($iScore['parents'] as $pid => $parent)
                    <div style="margin-bottom:5px;">
                        <div class="bar-label">{{ $parent['name'] }} &nbsp; {{ $parent['score'] }}/{{ $parent['maxScore'] }}</div>
                        <div class="bar-outer">
                            <div class="bar-inner" style="width:{{ $parent['pct'] }}%;background:{{ $color }}"></div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </td>
    @if(($ci + 1) % $cols == 0 || $ci == $cardCount - 1)
        {{-- Fill remaining cells in last row --}}
        @if($ci == $cardCount - 1 && ($ci + 1) % $cols != 0)
            @for($j = 0; $j < $cols - (($ci) % $cols) - 1; $j++)
                <td></td>
            @endfor
        @endif
    </tr>
    @endif
    @php $ci++; @endphp
@endforeach

@if($cardCount % $cols != 0)
    @for($j = 0; $j < $cols - ($cardCount % $cols); $j++)
        <td></td>
    @endfor
    </tr>
@endif
</table>

{{-- RADAR --}}
@if(file_exists($radarPath))
<div class="section-title" style="margin-top: 16px;">Radar Chart</div>
<div class="center">
    <img src="{{ $radarPath }}" width="430">
</div>
@endif

<div class="page-break"></div>

{{-- SINGLE CHART GROUP --}}
<div class="section-title">Location Radar Charts</div>
<table class="chart-grid">
@php
    $lci = 0;
    $lcols = 2;
    $locCount = count($industries);
@endphp
@foreach($industries as $industry)
    @if($lci % $lcols == 0)<tr>@endif
        <td>
            <div class="chart-title">{{ $industry->industry_name }}</div>
            @if(!empty($radarByLocationPaths[$industry->id]) && file_exists($radarByLocationPaths[$industry->id]))
                <img src="{{ $radarByLocationPaths[$industry->id] }}" width="340">
            @endif
        </td>
    @if(($lci + 1) % $lcols == 0 || $lci == $locCount - 1)
        @if($lci == $locCount - 1 && ($lci + 1) % $lcols != 0)
            @for($j = 0; $j < $lcols - (($lci) % $lcols) - 1; $j++)
                <td></td>
            @endfor
        @endif
    </tr>
    @endif
    @php $lci++; @endphp
@endforeach
</table>

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
@php
    $palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];
    $ci = 0;
@endphp
@foreach($industries as $industry)
    @php
        $color = $palette[$ci % count($palette)];
        $ci++;
    @endphp

    <div class="section-title">{{ $industry->industry_name }}</div>

    @if(isset($images[$industry->id]) && file_exists($images[$industry->id]))
        <div class="image-box">
            <img src="{{ $images[$industry->id] }}" width="250">
        </div>
    @endif

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

{{-- NOTES --}}
<div class="section-title">Notes</div>
<table>
    <tbody>
        <tr><td width="8%"><strong>I.</strong></td><td>{{ $project->notes_1 }}</td></tr>
        <tr><td width="8%"><strong>II.</strong></td><td>{{ $project->notes_2 }}</td></tr>
        <tr><td width="8%"><strong>III.</strong></td><td>{{ $project->notes_3 }}</td></tr>
        <tr><td width="8%"><strong>IV.</strong></td><td>{{ $project->notes_4 }}</td></tr>
    </tbody>
</table>

{{-- DISCLAIMER --}}
<div class="footer">
    <p>Disclaimer:<br>
    This document has been created based on various conditions and criteria provided by the Client.
    The evaluation results are calculated based on weighted scoring.
    We assume no legal responsibility for decisions made using this report.</p>
</div>

</body>
</html>
