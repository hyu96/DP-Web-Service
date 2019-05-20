@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Biểu đồ</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Giới tính</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <a href="{{ route('admin.report.export')}}?type=gender" class="btn btn-success pull-right"><i
                                    class="fa fa-download"> Export</i></a>
                    </div>
                    <div class="chart">
                        <canvas id="gender-chart" style="height:300px"></canvas>
                    </div>
-                </div>
                <div class="container-fluid">
                    <div id="gender-chart-type">
                        <label>
                            <input type="radio" value="bar" name="gender-chart-type" class="flat-red" checked>
                            Bar
                        </label>
                        <label>
                            <input type="radio" value="doughnut" name="gender-chart-type" class="flat-red">
                            Doughnut
                        </label>
                        <label>
                            <input type="radio" value="pie" name="gender-chart-type" class="flat-red">
                            Pie
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Khả năng lao động</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <a href="{{ route('admin.report.export')}}?type=labor_ability" class="btn btn-success pull-right"><i
                                    class="fa fa-download"> Export</i></a>
                    </div>
                    <div class="chart">
                        <canvas id="labor-ability-chart" style="height:300px"></canvas>
                    </div>
                </div>
                <div class="container-fluid">
                    <div id="labor-ability-chart-type">
                        <label>
                            <input type="radio" value="doughnut" name="labor-ability-chart-type" class="flat-red">
                            Doughnut
                        </label>
                        <label>
                            <input type="radio" value="pie" name="labor-ability-chart-type" class="flat-red">
                            Pie
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Dạng tật</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <a href="{{ route('admin.report.export')}}?type=disability" class="btn btn-success pull-right"><i
                                    class="fa fa-download"> Export</i></a>
                    </div>
                    <div class="chart">
                        <canvas id="disability-chart" style="height:300px"></canvas>
                    </div>
                </div>
                <div class="container-fluid">
                    <div id="need-chart-type">
                        <label>
                            <input type="radio" value="bar" name="disability-chart-type" class="flat-red" checked>
                            Bar
                        </label>
                        <label>
                            <input type="radio" value="radar" name="disability-chart-type" class="flat-red">
                            Radar
                        </label>
                        <label>
                            <input type="radio" value="polarArea" name="disability-chart-type" class="flat-red">
                            Polar Area
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nhu cầu hỗ trợ</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <a href="{{ route('admin.report.export')}}?type=need" class="btn btn-success pull-right"><i
                                    class="fa fa-download"> Export</i></a>
                    </div>
                    <div class="chart">
                        <canvas id="need-chart" style="height:300px"></canvas>
                    </div>
                </div>
                <div class="container-fluid">
                    <div id="need-chart-type">
                        <label>
                            <input type="radio" value="bar" name="need-chart-type" class="flat-red" checked>
                            Bar
                        </label>
                        <label>
                            <input type="radio" value="radar" name="need-chart-type" class="flat-red">
                            Radar
                        </label>
                        <label>
                            <input type="radio" value="polarArea" name="need-chart-type" class="flat-red">
                            Polar Area
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
        var genderChart;
        var laborAbilityChart;
        var disabilityChart;
        var needChart;

        function loadGenderChart(type = 'bar') {
            var customOptions = {
                maintainAspectRatio: false
            };

            if (type === 'bar') {
                customOptions.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            $.ajax({
                url : "/api/reports?type=gender",
                type : "get",
                dateType:"json",
                success : function (result){
                    console.log(type);
                    var userGender = [];
                    genderChart = new Chart(document.getElementById("gender-chart"), {
                        type: type,
                        data: {
                            labels: result.data.labels,
                            datasets: [
                                {
                                    label: '# Số người khuyết tật',
                                    data: result.data.count,
                                    backgroundColor: [
                                        '#f16954',
                                        '#39a65a',
                                    ]
                                }
                            ]
                        },
                        options: customOptions
                    });
                }
            }); 
        }

        function loadLaborAbilityChart(type = 'bar') {
            var customOptions = {
                maintainAspectRatio: false
            };

            if (type === 'bar') {
                customOptions.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            $.ajax({
                url : "/api/reports?type=labor_ability",
                type : "get",
                dateType:"json",
                success : function (result){
                    laborAbilityChart = new Chart(document.getElementById("labor-ability-chart"), {
                        type: type,
                        data: {
                            labels: result.data.labels,
                            datasets: [
                                {
                                    label: '# Số người khuyết tật',
                                    data: result.data.count,
                                    backgroundColor: [
                                        '#f16954',
                                        '#39a65a',
                                    ]
                                }
                            ]
                        },
                        options: customOptions
                    });
                }
            });
        }

        function loadDisabilityChart(type = 'bar') {
            var customOptions = {
                maintainAspectRatio: false
            };

            if (type === 'bar') {
                customOptions.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            $.ajax({
                url : "/api/reports?type=disability",
                type : "get",
                dateType:"json",
                success : function (result){
                    disabilityChart = new Chart(document.getElementById("disability-chart"), {
                        type: type,
                        data: {
                            labels: result.data.labels,
                            datasets: [
                                {
                                    label: '# Số người khuyết tật',
                                    data: result.data.count,
                                    backgroundColor: [
                                        '#f16954',
                                        '#39a65a',
                                        '#f39c14',
                                        '#53c0ef',
                                        '#3d8dbb',
                                        '#9966ff'
                                    ]
                                }
                            ]
                        },
                        options: customOptions
                    });
                }
            });
        }

        function loadNeedChart(type = 'bar') {
            var customOptions = {
                maintainAspectRatio: false
            };

            if (type === 'bar') {
                customOptions.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            $.ajax({
                url : "/api/reports?type=need",
                type : "get",
                dateType:"json",
                success : function (result){
                    needChart = new Chart(document.getElementById("need-chart"), {
                        type: type,
                        data: {
                            labels: result.data.labels,
                            datasets: [
                                {
                                    label: '# Số người khuyết tật',
                                    data: result.data.count,
                                    backgroundColor: [
                                        '#f16954',
                                        '#39a65a',
                                        '#f39c14',
                                        '#53c0ef',
                                        '#3d8dbb',
                                        '#9966ff',
                                        '#d2d6de'
                                    ]
                                }
                            ]
                        },
                        options: customOptions
                    });
                }
            });
        }

        loadGenderChart();
        loadLaborAbilityChart();
        loadDisabilityChart();
        loadNeedChart();

        $('input:radio[name=gender-chart-type]').change(function () {
            var chartType = $(this).val();
            genderChart.destroy();
            loadGenderChart(chartType);
        });

        $('input:radio[name=labor-ability-chart-type]').change(function () {
            var chartType = $(this).val();
            laborAbilityChart.destroy();
            loadLaborAbilityChart(chartType);
        });

        $('input:radio[name=need-chart-type]').change(function () {
            var chartType = $(this).val();
            needChart.destroy();
            loadNeedChart(chartType);
        });

        $('input:radio[name=disability-chart-type]').change(function () {
            var chartType = $(this).val();
            disabilityChart.destroy();
            loadDisabilityChart(chartType);
        });
    })
</script>
@endsection

