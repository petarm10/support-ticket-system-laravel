@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        <form method="POST" action="{{ route('admin.assign_role') }}">
            @csrf

            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">--Select User--</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="role_id">Assign Role:</label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value="">--Assign Role--</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Assign Role</button>
        </form>
    </div>
@endsection
