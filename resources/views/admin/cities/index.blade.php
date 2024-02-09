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
            <span class="fs-2">Cities</span>
            <div>
                <a class="btn btn-primary" href="{{ route('admin.cities.add') }}">Add City</a>
            </div>
        </div>

        <div class="card p-3">
            <table id="cityTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $city)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="show">{{ $city->name }}</td>
                            <td>
                                <a href="cities/{{ $city->id }}/edit" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </a>
                                <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Delete">
                                    <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                        data-bs-target="#popupDelete"
                                        onclick="changeModalValue('{{ $city->name }}', '{{ $city->id }}')">
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
                                <input type="hidden" name="city_id" id="deleteCityId">
                                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes, delete it</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cityTable').DataTable({
                responsive: true,
                dom: '<"mb-3"B><"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
                buttons: [{
                    extend: 'csvHtml5',
                    title: 'City',
                    className: 'btn-success',
                    text: 'Export Excel',
                    sheetName: 'City',
                    exportOptions: {
                        columns: [0, 1]
                    }
                }, {
                    extend: 'pdfHtml5',
                    title: 'City',
                    className: 'btn-secondary',
                    text: 'Export PDF',
                    sheetName: 'City',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    customize: function(doc) {
                        // console.log(doc)
                        doc.content[1].table.widths = ['*', '*']
                        doc.styles.tableBodyOdd.alignment = 'center'
                        doc.styles.tableBodyEven.alignment = 'center'
                    }
                }, ],

            });

        })

        const changeModalValue = (name, id) => {
            $('#popupDelete-name').text(name)
            $('#deleteCityId').val(id)
        }
    </script>
@endsection
