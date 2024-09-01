@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Shops</h1>
    <a href="{{ route('shops.create') }}" class="btn btn-primary">Add New Shop</a>
    <ul>
        @foreach($shops as $shop)
            <li>{{ $shop->name }} - {{ $shop->address }}
                <a href="{{ route('shops.edit', $shop->id) }}">Edit</a>
                <form action="{{ route('shops.destroy', $shop->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
