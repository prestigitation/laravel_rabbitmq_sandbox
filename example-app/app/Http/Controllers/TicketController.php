<?php

namespace App\Http\Controllers;

use App\Actions\SendEmailWhenTicketBought;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Flight;
use App\Repositories\TicketRepository;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private TicketRepository $ticketRepository, private SendEmailWhenTicketBought $sendInitialEmail){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $this->ticketRepository->store($request->validated());

        $this->sendInitialEmail->handle([
            'flight' => Flight::find($request->query('flight_id')),
            'email' => $request->get('email')
        ]);

        return redirect()->back()->with('message', 'You successfully booked the flight!')->with('alert-class', 'alert-success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
