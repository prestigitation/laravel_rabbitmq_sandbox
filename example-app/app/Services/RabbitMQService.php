<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Classes\AMQPService;

class RabbitMQService extends AMQPService {
    public $connection;
    public function __construct() {
        $this->connect();
    }
    public function connect() {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'));
    }
}
