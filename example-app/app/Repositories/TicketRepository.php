<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository {
    public function store(array $validatedData) {
        return Ticket::create($validatedData);
    }
}
