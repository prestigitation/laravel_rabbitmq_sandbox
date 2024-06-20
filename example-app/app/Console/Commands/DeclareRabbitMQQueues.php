<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;

class DeclareRabbitMQQueues extends Command
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
    protected $signature = 'app:declare-rabbitmq-queues';

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
        $channel->exchange_declare('EmailExchange', 'direct', false, true, false);
        $channel->exchange_declare('FlightExchange', 'topic', false, true, false);

        $channel->queue_declare('EmailQueue', false, true, false, false);
        $channel->queue_declare('FlightQueue', false, true, false, false);

        $channel->queue_bind('EmailQueue', 'EmailExchange', 'booking.success.email');
        $channel->queue_bind('FlightQueue', 'FlightExchange', 'booking.*.#');

        $channel->close();
    }
}
