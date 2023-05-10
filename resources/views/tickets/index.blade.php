@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Support Tickets</h1>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create Ticket</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Assigned To</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->priority }}</td>
                        <td>{{ $ticket->status }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>{{ $ticket->agent ? $ticket->agent->name : '-' }}</td>
                        <td><a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
