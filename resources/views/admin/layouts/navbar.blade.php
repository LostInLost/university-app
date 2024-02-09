@extends('app')

@section('content')
    <section class=" bg-primary bg-opacity-25 h-100">
        <nav class="navbar navbar-expand-lg bg-primary sticky-top">
            <div class="container-fluid d-flex justify-content-between">
                <a href="/" class="navbar-brand text-white">University Dashboard </a>
                <div class="d-flex gap-3 text-white align-items-center">
                    <span>{{ Auth::user()->name }}</span>
                    <div class="dropdown cursor-pointer">
                        <img src="{{ asset('default-2.jpg') }}" class="rounded-circle dropdown-toggle cursor-pointer"
                            data-bs-toggle="dropdown" aria-expanded="false" width="40" height="40" alt="">
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                    <button
                                        class="dropdown-item text-danger d-flex justify-content-between align-items-center"
                                        type="submit">Logout
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                            <path fill-rule="evenodd"
                                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>
        <div class="row h-100">
            <aside class="col-2 p-3">
                <ul class="list-group w-100 rounded">
                    <a href="{{ route('admin.index') }}"
                        class="list-group-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <span class="fs-4 d-flex gap-3 align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-speedometer" viewBox="0 0 16 16">
                                <path
                                    d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                                <path fill-rule="evenodd"
                                    d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0" />
                            </svg>
                            Dashboard
                        </span>
                    </a>
                    <div class="accordion accordion-flush list-group-item">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    class="accordion-button {{ str_contains(Request::url(), 'admin/dashboard/students') || str_contains(Request::url(), 'admin/dashboard/cities') ? '' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Data
                                </button>
                            </h2>
                            <div id="collapseOne"
                                class="accordion-collapse collapse {{ str_contains(Request::url(), 'admin/dashboard/students') || str_contains(Request::url(), 'admin/dashboard/cities') ? 'show' : '' }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-group">
                                        <a href="{{ route('admin.students.index') }}"
                                            class="list-group-item {{ str_contains(Request::url(), 'admin/dashboard/students') ? 'active' : '' }}">
                                            Students
                                        </a>
                                        <a href="{{ route('admin.cities.index') }}"
                                            class="list-group-item {{ str_contains(Request::url(), 'admin/dashboard/cities') ? 'active' : '' }}">
                                            Cities
                                        </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </aside>
            <section class="col-10 bg-white">
                @yield('content-with-nav')
            </section>
        </div>
    </section>
@endsection
