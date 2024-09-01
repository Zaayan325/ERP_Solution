@extends('admin.layouts.main')

@section('content')
<div>
    <h2>Migrate Tables</h2>
    <form method="POST" action="{{ route('migrate.run') }}">
        @csrf
        <div>
            <button type="submit">Run Migrations</button>
        </div>
    </form>
</div>
@endsection
