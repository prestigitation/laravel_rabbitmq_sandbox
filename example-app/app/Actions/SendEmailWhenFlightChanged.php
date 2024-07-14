<?php

namespace App\Actions;

use App\Services\RabbitMQService;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use PhpAmqpLib\Message\AMQPMessage;

class SendEmailWhenFlightChanged
{
    use AsAction;

    public function __construct(private RabbitMQService $rabbitMQService) {}

    public function handle(array $data)
    {
        $channel = $this->rabbitMQService->connection->channel();

        $message = new AMQPMessage(json_encode($data));

        $channel->basic_publish($message, 'FlightExchange', 'booking.flight.updated');

        $channel->close();
        $this->rabbitMQService->connection->close();
    }
}
