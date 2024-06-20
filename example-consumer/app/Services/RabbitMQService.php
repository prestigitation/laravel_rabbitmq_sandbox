<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService {
    public $connection;
    public function __construct() {
        $this->connect();
    }
    public function connect() {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'));
    }
}
