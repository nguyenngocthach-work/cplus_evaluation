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
    <div class="subtitle">
        Project: {{ $project->project_name }}
    </div>
    <div class="subtitle">
        Location: {{ $industry->industry_name }}
    </div>
</div>

{{-- SCORE TABLE --}}
<div class="section-title">Detailed Scoring</div>

@if(!empty($locationRadarPath) && file_exists($locationRadarPath))
<div class="section-title">Spider / Radar Chart</div>
<div style="text-align:center; margin-bottom: 12px;">
    <img src="{{ $locationRadarPath }}" width="340">
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

        {{-- Parent --}}
        <tr class="parent-row">
            <td>{{ $parent['name'] }}</td>
            <td>{{ $parent['score'] }}</td>
            <td>{{ $parent['maxScore'] }}</td>
        </tr>

        {{-- Children --}}
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

    {{-- TOTAL --}}
    <tr class="total-row">
        <td>TOTAL SCORE</td>
        <td>{{ $locationScore['total'] }}</td>
        <td>100</td>
    </tr>

    </tbody>
</table>

{{-- FOOTER --}}
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