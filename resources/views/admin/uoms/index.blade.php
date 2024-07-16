@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Units of Measurement</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Units of Measurement</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Units of Measurement List</h5>
                        <a href="{{ route('uoms.create') }}" class="btn btn-primary mb-3">Add Unit of Measurement</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uoms as $uom)
                                    <tr>
                                        <th scope="row">{{ $uom->id }}</th>
                                        <td>{{ $uom->name }}</td>
                                        <td>
                                            <a href="{{ route('uoms.edit', $uom->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('uoms.destroy', $uom->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
