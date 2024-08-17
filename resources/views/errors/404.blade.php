@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Error Pager</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">error 404</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Error Page 404</h5>
                        <h1>Hi Sorry for disturbance
                        </h1>
                        <h3>
                            You Got to the wrong page
                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection