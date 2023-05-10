<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tickets = SupportTicket::query();
        if ($user->hasRole('admin') || $user->hasRole('agent')) {
            // Allow admins and agents to see all tickets
        } elseif ($user->hasRole('user')) {
            // Allow users to see their own tickets only
            $tickets = $tickets->where('user_id', $user->id);
        }
        $tickets = $tickets->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ]);

        $ticket = new SupportTicket;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->priority = $request->priority;
        $ticket->status = 'open';
        $ticket->user_id = auth()->user()->id;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        // $agents = User::where('role', 'agent')->get();
        $agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->get();
        return view('tickets.show', compact('ticket', 'agents'));
    }

    public function edit($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        if (auth()->user()->hasRole('user') && $ticket->user_id !== auth()->id()) {
            return redirect()->route('tickets.index')
                ->with('error', 'You are not authorized to edit this ticket.');
        }

        // fetch the list of agents with the 'agent' role
        $agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->get();

        return view('tickets.edit', compact('ticket', 'agents'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->priority = $request->priority;
        $ticket->save();

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index');
    }

    //only admins can assign
    public function assign(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $agent = User::find($request->input('agent_id'));

        $supportTicket->assignAgent($agent);

        return redirect()->route('tickets.show', ['ticket' => $supportTicket]);
    }

    //only admin can reassign
    public function reassign(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'You are not authorized to perform this action.');
        }

        $agent = User::find($request->input('agent_id'));

        $supportTicket->reassignAgent($agent);

        return redirect()->route('tickets.show', ['ticket' => $supportTicket]);
    }
}
