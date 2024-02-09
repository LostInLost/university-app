@extends('admin.layouts.navbar')

@section('content-with-nav')
    <h1>Dashboard Main {{ Auth::user()->name }}</h1>
    <div class="row gap-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-4">Total Students By City</span>
                </div>
                <div class="card-body d-flex justify-content-center">
                    {{-- <canvas id="chart" tabindex="999" width="400px" height="400px"></canvas> --}}
                    <input type="hidden" id="adminId" value="{{ Auth::user()->id }}" name="">
                    <div id="chart" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-4">Total Students By Gender</span>
                </div>
                <div class="card-body d-flex justify-content-center">
                    {{-- <canvas id="chart" tabindex="999" width="400px" height="400px"></canvas> --}}
                    <div id="chart2" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-4">Total Students By Years</span>
                </div>
                <div class="card-body d-flex justify-content-center">
                    {{-- <canvas id="chart" tabindex="999" width="400px" height="400px"></canvas> --}}
                    <div id="chart3" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! $studentByCityChart->script() !!}

    <script>
        $(document).ready(function() {
            const chart1 = document.getElementById('chart');
            const chart2 = document.getElementById('chart2');
            const chart3 = document.getElementById('chart3');
            const myChart = echarts.init(chart1);
            const myChart2 = echarts.init(chart2);
            const myChart3 = echarts.init(chart3);

            const id = $('#adminId').val()
            $.get(`http://localhost:8000/api/admin/${id}/dashboard`).done((data) => {

                let option;
                let option2;
                let option3;

                option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        top: '5%',
                        left: 'center'
                    },
                    series: [{
                        name: 'Student By City',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 10,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 24,
                                fontWeight: 'bold'
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: data.studentByCity
                    }]
                };

                option2 = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        orient: 'horizontal',
                        left: 'center'
                    },
                    series: [{
                        name: 'Access From',
                        type: 'pie',
                        radius: '50%',
                        data: [data.studentByGender['L'], data.studentByGender['P']],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                };

                let students = data.studentByYear;
                let years = [];
                let total = [];
                students.forEach(student => {
                    const date = new Date(student.born_date);
                    if (!years.find(year => year === date.getFullYear())) {
                        years = [...years, date.getFullYear()]
                    }
                    // years[date.getFullYear()] += 1
                });

                option3 = {
                    xAxis: {
                        type: 'category',
                        data: years
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        data: [1, 2],
                        type: 'bar'
                    }]
                };

                option && myChart.setOption(option);
                option2 && myChart2.setOption(option2);
                option3 && myChart3.setOption(option3);
            })
        });
    </script>
@endsection
