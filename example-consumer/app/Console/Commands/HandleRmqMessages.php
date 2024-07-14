<?php

namespace App\Console\Commands;

use App\Mail\BookingChangedMailable;
use App\Mail\BookingSuccessMailable;
use App\Services\RabbitMQService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleRmqMessages extends Command
{
    private $rabbitMQService;

    public function __construct() {
        parent::__construct();
        $this->rabbitMQService = new RabbitMQService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:handle-rmq-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $channel = $this->rabbitMQService->connection->channel();

        $handleSuccessBooking = function ($message) {
            $messageBody = json_decode($message->body);
            Mail::to($messageBody->email)->send(new BookingSuccessMailable($messageBody->flight));
        };

        $handleBookingChange = function ($message) {
            $messageBody = json_decode($message->body);
            Mail::to($messageBody->email)->send(new BookingChangedMailable($messageBody->changes));
        };

        $channel->basic_consume('EmailQueue', 'booking.success.email', false, true, false, false, $handleSuccessBooking);
        $channel->basic_consume('FlightQueue', 'booking.flight.#', false, true, false, false, $handleBookingChange);

        while($channel->is_open()) {
            $channel->wait();
        }
    }
}
