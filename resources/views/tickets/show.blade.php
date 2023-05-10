@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $ticket->title }}</h1>
        <p><strong>Description:</strong> {{ $ticket->description }}</p>
        <p><strong>Priority:</strong> {{ $ticket->priority }}</p>
        <p><strong>Status:</strong> {{ $ticket->status }}</p>
        <p><strong>Created By:</strong> {{ $ticket->user->name }}</p>
        <p>
            <strong>Assigned To:</strong>
            @if($ticket->agent_id)
                {{ $ticket->agent->name }}
                <form action="{{ route('tickets.reassign', ['supportTicket' => $ticket->id]) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <div class="form-group">
                        <label for="agent_id">Reassign to agent:</label>
                        <select name="agent_id" id="agent_id" class="form-control">
                            <option value="">Choose an agent</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Reassign</button>
                </form>
            @else
                -
                <form action="{{ route('tickets.assign', ['supportTicket' => $ticket->id]) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <div class="assign-form" style="display:inline-flex;gap:1rem;">
                    <div class="form-group">
                        <select name="agent_id" id="agent_id" class="form-control">
                            <option value="">Choose an agent</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            @endif
        </p>
        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
