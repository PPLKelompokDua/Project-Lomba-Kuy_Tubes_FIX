@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <div id="chart_div" style="height: 500px;"></div>
        </div>
    </div>
    <br>
    <a href="{{ route('milestones.index', $competition->id) }}" class="btn btn-secondary">← Kembali ke Milestone</a>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        data.addRows([
            @foreach ($milestones as $m)
                [
                    '{{ $m["id"] }}',
                    '{{ $m["title"] }}',
                    '{{ $m["is_done"] ? "✅ Done" : "⏳ Progress" }}',
                    new Date('{{ $m["start"] }}'),
                    new Date('{{ $m["end"] }}'),
                    null,
                    {{ $m["is_done"] ? 100 : 0 }},
                    null
                ]@if (!$loop->last),@endif
            @endforeach
        ]);

        var options = {
            height: 500,
            gantt: {
                trackHeight: 40,
                labelStyle: {
                    fontName: "Arial",
                    fontSize: 14,
                    color: '#333'
                },
                percentEnabled: true
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
@endsection
