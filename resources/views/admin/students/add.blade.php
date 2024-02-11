@extends('admin.layouts.navbar')


@section('content-with-nav')
    <section class="p-3 d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h3>Add Student</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->all()[0] }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <form action="" method="post" class="container gap-3">
                    @csrf
                    <div class="row my-3">
                        <div class="col">
                            <label for="nim">NIM</label>
                            <input type="text" value="{{ old('nim') }}" required placeholder="Type here..."
                                class="form-control" name="nim" id="nim">
                        </div>
                        <div class="col">
                            <label for="name">Name</label>
                            <input type="text" required value="{{ old('name') }}" placeholder="Type here..."
                                class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label for="bord-date">Born Date</label>
                            <input type="date" required value="{{ old('born_date') }}" placeholder="Type here..."
                                class="form-control" name="born_date" id="born-date">
                        </div>
                        <div class="col">
                            <label for="sex">Gender</label>
                            <select name="sex" id="sex" class="form-select" required>
                                <option value="">Select the Gender</option>
                                <option value="L" {{ old('sex') === 'L' ? 'selected' : '' }}>Male</option>
                                <option value="P" {{ old('sex') === 'P' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label for="city">City</label>
                            <select name="city_id" id="city" class="form-select" required>
                                <option value="">Select the city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id') === $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Type here...">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>


    </section>
@endsection
