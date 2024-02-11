@extends('admin.layouts.navbar')


@section('content-with-nav')
    <section class="m-3">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <span class="fs-2">Students</span>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.students.add') }}">Add Student</a>
            </div>
        </div>

        <div class="card p-3">
            <table id="studentTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Born Date</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="show">{{ $student->nim }}</td>
                            <td>{{ \Carbon\Carbon::parse($student->born_date)->format('m/d/Y') }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->city->name }}</td>
                            <td>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#popupDetail"
                                    onclick="showDetail('{{ $student->name }}', '{{ $student->nim }}', '{{ $student->born_date }}', '{{ $student->sex }}', '{{ $student->city->name }}', '{{ $student->address }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </button>
                                <a href="students/{{ $student->id }}/edit" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </a>
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Delete">
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                        data-bs-target="#popupDelete"
                                        onclick="changeModalValue('{{ $student->name }}', '{{ $student->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal fade" tabindex="-1" id="popupDelete" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure to delete <b><span id="popupDelete-name"></span></b>?</p>
                        </div>
                        <form action="" method="post">
                            @csrf
                            <div class="modal-footer">
                                <input type="hidden" name="student_id" id="deleteStudentId">
                                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes, delete it</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="popupDetail" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail <span></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" id="loadingDetail">
                            <h1>Loading...</h1>
                        </div>
                        <div class="modal-body" id="modalDetail">
                            <div class="row my-3">
                                <div class="col">
                                    <label for="nim">NIM</label>
                                    <input type="text" disabled required placeholder="Type here..." class="form-control"
                                        name="nim" id="nim">
                                </div>
                                <div class="col">
                                    <label for="name">Name</label>
                                    <input type="text" required placeholder="Type here..." class="form-control"
                                        name="name" id="name" disabled>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="bord-date">Born Date</label>
                                    <input type="date" required placeholder="Type here..." class="form-control"
                                        name="born_date" id="born-date" disabled>
                                </div>
                                <div class="col">
                                    <label for="sex">Gender</label>
                                    <input type="text" class="form-control" name="" id="sex" disabled>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="" id="city" disabled>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" disabled cols="30" rows="5"
                                        placeholder="Type here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#studentTable').DataTable({
                responsive: true,
                dom: '<"mb-3"B><"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
                buttons: [{
                    extend: 'csvHtml5',
                    title: 'Students',
                    className: 'btn-success',
                    text: `<div class="d-flex gap-3 align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-spreadsheet" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v4h10V2a1 1 0 0 0-1-1zm9 6h-3v2h3zm0 3h-3v2h3zm0 3h-3v2h2a1 1 0 0 0 1-1zm-4 2v-2H6v2zm-4 0v-2H3v1a1 1 0 0 0 1 1zm-2-3h2v-2H3zm0-3h2V7H3zm3-2v2h3V7zm3 3H6v2h3z"/>
                        </svg>
                        <span>Export Excel</span>
                        </div>`,
                    sheetName: 'Students',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }, {
                    extend: 'pdfHtml5',
                    title: 'Students',
                    className: 'btn-secondary',
                    text: `<div class="d-flex gap-3 align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                        </svg>
                        <span>Export PDF</span>
                        </div>`,
                    sheetName: 'Students',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function(doc) {
                        doc.content[1].table.widths = ['*', '*', '*', '*', '*']
                        doc.styles.tableBodyOdd.alignment = 'center'
                        doc.styles.tableBodyEven.alignment = 'center'
                    }
                }, ],

            });

        })

        const changeModalValue = (name, id) => {
            $('#popupDelete-name').text(name)
            $('#deleteStudentId').val(id)
        }

        const showDetail = (name, nim, born_date, sex, city_name, address) => {

            // WITH API
            // $('#loadingDetail').removeClass('d-none')
            // $('#modalDetail').addClass('d-none')
            // $.get('http://localhost:8000/api/admin/dashboard/students/' + id, function(data, status) {
            //     if (status !== 'success') return
            //     // console.log(data.data.name)
            //     $('#loadingDetail').addClass('d-none')
            //     $('#modalDetail').removeClass('d-none')
            //     $('#nim').val(data.student.nim)
            //     $('#name').val(data.student.name)
            //     $('#born-date').val(data.student.born_date)
            //     $('#sex').val(data.student.sex)
            //     $('#city').val(data.student.city.name)
            //     $('#address').text(data.student.address)
            // })

            $('#loadingDetail').addClass('d-none')
            $('#nim').val(nim)
            $('#name').val(name)
            $('#born-date').val(born_date)
            $('#sex').val(sex === 'L' ? 'Male' : 'Female')
            $('#city').val(city_name)
            $('#address').text(address)
        }
    </script>
@endsection
