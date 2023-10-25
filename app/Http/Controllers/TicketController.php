<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UpdatedTicketStatusNotify;
use App\Models\User;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tickets = Ticket::all();

        $user = auth()->user();
        //Latest means if tickets orderby('created at') and If admin then can see all the tickets and User only see their tickets
        $tickets = $user->isAdmin ? Ticket::latest()->get() : $user->tickets;

        return view('ticket/index', compact('tickets'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);

        if ($request->file('attachment') != NULL) {
           $this->StoreAttachment($request, $ticket);
        }
        //dd($ticket);
        return response()->redirectTO(route('ticket.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        
        return view('ticket/show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {

        return view('ticket/edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {   
        
        $ticket->update($request->except('attachment'));

        if($request->has('status')){
            $user = User::find($ticket->user_id);
            // $user->notify(new UpdatedTicketStatusNotify($ticket));

            return (new UpdatedTicketStatusNotify($ticket))->toMail($user);
        };

        if ($request->file('attachment') != NULL) {
            Storage::disk('public')->delete($ticket->attachment);
            $this->StoreAttachment($request, $ticket);
        }

        return response()->redirectTO(route('ticket.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return response()->redirectTO(route('ticket.index'));
    }

    //Store attachment function here

    protected function StoreAttachment($request, $ticket)
    {
        $ext = $request->file('attachment')->getClientOriginalExtension();
        $content = $request->file('attachment')->getContent();
        $filename = $ticket->id . '.' . $ext;
        $path = 'attachments/' . $filename;
        Storage::disk('public')->put($path, $content);
        $ticket->update(['attachment' => $path]);
    }
}
