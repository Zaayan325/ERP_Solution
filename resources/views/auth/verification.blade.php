@extends('admin.layouts.main')

@section('content')
<div>
    <h2>Verify Your Account</h2>
    <form method="POST" action="{{ route('verification.submit') }}">
        @csrf
        <div>
            <label for="code">Enter Verification Code</label>
            <input type="text" name="code" id="code">
        </div>
        <div>
            <button type="submit">Verify</button>
            <button type="submit" name="skip" value="true">Skip</button>
        </div>
    </form>
</div>
@endsection
