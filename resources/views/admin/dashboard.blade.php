@extends('admin.layouts.navbar')

@section('content-with-nav')
    <h1>Dashboard Main {{ Auth::user()->name }}</h1>
    <div class="row my-3">
        <div class="col">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                        <div class="d-flex flex-column">
                            <h3>Total Students</h3>
                            <span class="fs-3"><b id="totalStudents">Loading...</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-person-standing" viewBox="0 0 16 16">
                            <path
                                d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0" />
                        </svg>
                        <div class="d-flex flex-column">
                            <h3>Male Students</h3>
                            <span class="fs-3"><b id="totalMaleStudents">Loading...</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-person-standing-dress" viewBox="0 0 16 16">
                            <path
                                d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.5 12.25V12h1v3.25a.75.75 0 0 0 1.5 0V12h1l-1-5v-.215a.285.285 0 0 1 .56-.078l.793 2.777a.711.711 0 1 0 1.364-.405l-1.065-3.461A3 3 0 0 0 8.784 3.5H7.216a3 3 0 0 0-2.868 2.118L3.283 9.079a.711.711 0 1 0 1.365.405l.793-2.777a.285.285 0 0 1 .56.078V7l-1 5h1v3.25a.75.75 0 0 0 1.5 0Z" />
                        </svg>
                        <div class="d-flex flex-column">
                            <h3>Female Students</h3>
                            <span class="fs-3"><b id="totalFemaleStudents">Loading...</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gap-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-2"><b>Total Students By Gender</b></span>
                </div>
                <div class="card-body d-flex justify-content-center">

                    <input type="hidden" id="adminId" value="{{ Auth::user()->id }}" name="">
                    <div id="chart" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-2"><b>Total Students By City</b></span>
                </div>
                <div class="card-body d-flex justify-content-center">

                    <div id="chart2" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gap-3 my-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="fw-4"><b>Total Students By Years of Birth</b></span>
                </div>
                <div class="card-body d-flex justify-content-center">

                    <div id="chart3" style="width: 400px;height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
                let totalStudents = 0;

                data.studentByGender.forEach((gender) => {
                    totalStudents += gender.value
                    if (gender.name === 'Male') return $('#totalMaleStudents').text(gender.value)
                    if (gender.name === 'Female') return $('#totalFemaleStudents').text(gender
                        .value)
                })

                $('#totalStudents').text(totalStudents)
                option = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        top: '5%',
                        left: 'center'
                    },
                    series: [{
                        name: 'Student By Gender',
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
                        data: data.studentByGender
                    }]
                };

                option2 = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        show: false,
                        orient: 'horizontal',
                        left: 'center'
                    },
                    series: [{
                        name: 'Student By City',
                        type: 'pie',
                        radius: '50%',
                        data: data.studentByCity,
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }]
                };

                option3 = {
                    xAxis: {
                        type: 'category',
                        data: data.studentByYear.category
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        data: data.studentByYear.value,
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
