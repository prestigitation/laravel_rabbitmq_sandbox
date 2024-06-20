<?php

namespace App\Classes;

abstract class AMQPService {
    private $connection;
    public function connect() {}
    public function send() {}
    public function handle() {}
}
