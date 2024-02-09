@extends('admin.layouts.navbar')


@section('content-with-nav')
    <section class="p-3 d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h3>Edit City</h3>
            </div>
            <div class="card-body">
                @if ($errors->all()[0] ?? false)
                    <div class="alert alert-danger">
                        {{ $errors->all()[0] }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <form action="" method="post" class="d-flex flex-column gap-3 ">
                    @csrf
                    <div class="">
                        <label for="city-name">City Name</label>
                        <input type="text" required placeholder="Type here..." value="{{ $city->name }}"
                            class="form-control" name="name" id="city-name">
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>


    </section>
@endsection
