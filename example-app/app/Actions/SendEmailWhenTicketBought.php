<?php

namespace App\Actions;

use App\Models\User;
use App\Services\RabbitMQService;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use PhpAmqpLib\Message\AMQPMessage;

class SendEmailWhenTicketBought
{
    use AsAction;

    public function __construct(private RabbitMQService $rabbitMQService) {}

    public function handle(array $flightInfo)
    {
        $channel = $this->rabbitMQService->connection->channel();

        $message = new AMQPMessage(json_encode($flightInfo));

        $channel->basic_publish($message, 'EmailExchange', 'booking.success.email');

        $channel->close();
        $this->rabbitMQService->connection->close();
    }
}
