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
                    <div class="chart">
                        <canvas id="gender-chart" style="height:300px"></canvas>
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
                    <div class="chart">
                        <canvas id="labor-ability-chart" style="height:300px"></canvas>
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
                    <div class="chart">
                        <canvas id="disability-chart" style="height:300px"></canvas>
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
                    <div class="chart">
                        <canvas id="need-chart" style="height:300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
        function loadGenderChart() {
            $.ajax({
                url : "/api/reports?type=gender",
                type : "get",
                dateType:"json",
                success : function (result){
                    console.log(result);
                    var userGender = [];
                    var genderChart = new Chart(document.getElementById("gender-chart"), {
                        type: 'pie',
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
                        }
                    });
                }
            }); 
        }

        function loadLaborAbilityChart() {
            $.ajax({
                url : "/api/reports?type=labor_ability",
                type : "get",
                dateType:"json",
                success : function (result){
                    var laborAbilityChart = new Chart(document.getElementById("labor-ability-chart"), {
                        type: 'pie',
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
                        }
                    });
                }
            });
        }

        function loadDisabilityChart() {
            $.ajax({
                url : "/api/reports?type=disability",
                type : "get",
                dateType:"json",
                success : function (result){
                    var disabilityChart = new Chart(document.getElementById("disability-chart"), {
                        type: 'bar',
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
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

        function loadNeedChart() {
            $.ajax({
                url : "/api/reports?type=need",
                type : "get",
                dateType:"json",
                success : function (result){
                    var needChart = new Chart(document.getElementById("need-chart"), {
                        type: 'bar',
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
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

        loadGenderChart();
        loadLaborAbilityChart();
        loadDisabilityChart();
        loadNeedChart();
    })
</script>
@endsection

