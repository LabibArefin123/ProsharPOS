@extends('adminlte::page')

@section('title', 'System Health Dashboard')

@section('content_header')
    <h1>🚀 System Health Dashboard</h1>
@stop

@section('content')

    <!-- 🔥 STATS CARDS -->
    <div class="row">

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="avgScore">--</h3>
                    <p>Average Score</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="nplus">--</h3>
                    <p>N+1 Issues</p>
                </div>
                <div class="icon"><i class="fas fa-bug"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="unused">--</h3>
                    <p>Unused Columns</p>
                </div>
                <div class="icon"><i class="fas fa-database"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="models">--</h3>
                    <p>Total Models</p>
                </div>
                <div class="icon"><i class="fas fa-cubes"></i></div>
            </div>
        </div>

    </div>

    <!-- 🔍 TABLE -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Model Performance Analysis</h3>
        </div>

        <div class="card-body">
            <input type="text" id="search" class="form-control mb-3" placeholder="🔍 Search model...">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Score</th>
                        <th>Quality</th>
                        <th>N+1</th>
                        <th>Unused</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>

@stop

@section('js')
    <script>
        function loadData(search = '') {
            fetch('/db-visualizer/data?search=' + search)
                .then(res => res.json())
                .then(data => {

                    let rows = '';
                    let totalScore = 0;
                    let totalN = 0;
                    let totalUnused = 0;

                    data.forEach(item => {

                        totalScore += item.performance_score;
                        totalN += item.n_plus_one_issues;
                        totalUnused += item.unused_columns_count;

                        rows += `
                        <tr>
                            <td>${item.model}</td>
                            <td><span class="badge bg-info">${item.performance_score}</span></td>
                            <td>${item.quality_label}</td>
                            <td><span class="badge bg-danger">${item.n_plus_one_issues}</span></td>
                            <td><span class="badge bg-warning">${item.unused_columns_count}</span></td>
                        </tr>
                    `;
                    });

                    document.getElementById('tableBody').innerHTML = rows;

                    // update stats
                    document.getElementById('models').innerText = data.length;
                    document.getElementById('nplus').innerText = totalN;
                    document.getElementById('unused').innerText = totalUnused;
                    document.getElementById('avgScore').innerText =
                        data.length ? Math.round(totalScore / data.length) : 0;
                });
        }

        loadData();

        document.getElementById('search').addEventListener('keyup', function() {
            loadData(this.value);
        });
    </script>
@stop
