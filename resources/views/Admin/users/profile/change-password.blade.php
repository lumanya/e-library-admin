
@extends('layouts.dashboard')

@section('content')

<div class="col-md-8 offset-2">
    <div class="card">
        <div class="card-block p-2">
            <div class="col-md-12">
                @include('Admin.users.profile.password_form')
            </div>
        </div>
    </div>
</div>

@endsection
