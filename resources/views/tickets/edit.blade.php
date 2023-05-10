@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Support Ticket</h1>
        <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $ticket->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ $ticket->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="">Select Priority</option>
                    <option value="low"{{ $ticket->priority === 'low' ? ' selected' : '' }}>Low</option>
                    <option value="medium"{{ $ticket->priority === 'medium' ? ' selected' : '' }}>Medium</option>
                    <option value="high"{{ $ticket->priority === 'high' ? ' selected' : '' }}>High</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div>
@endsection
