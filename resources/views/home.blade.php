@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="container-fluid bg-light">
                    <div class="container mt-3">
                        <p style="text-align:center;">
                            Logged in as {{ auth()->user()->name }} with role: {{ $role ? $role->name : 'No role assigned' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
