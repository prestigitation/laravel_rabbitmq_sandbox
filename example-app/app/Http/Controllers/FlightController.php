<?php

namespace App\Http\Controllers;

use App\Actions\SendEmailWhenFlightChanged;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use App\Http\Requests\UpdateFlightRequest;
use App\Models\Flight;

class FlightController extends Controller
{
    public function __construct(private SendEmailWhenFlightChanged $sendEmailAboutUpdate) {
        $this->middleware(IsAdmin::class)->only('edit');
    }
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
    public function store(Request $request)
    {
        //
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
        return view('flights.flight_edit', [
            'flight' => Flight::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlightRequest $request, string $id)
    {
        $changes = $request->validated();
        Flight::find($id)->update($changes);

        $this->sendEmailAboutUpdate->handle($changes);

        return redirect("/")->with('message', 'You successfully changed the flight!')->with('alert-class', 'alert-success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
