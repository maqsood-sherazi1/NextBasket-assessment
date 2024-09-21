<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class UserController extends Controller {
    // method to store the user data
    public function store(Request $request) {
        $data = $request>validate([
            'email' => 'required|email|unique:users,email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);

        $user = User::create([
            'email' => $data['email'],
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName']
        ]);

        $this->sendNotification($user);
        return response()->json($user, 201);
    }

    private function sendNotification($user) {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('notifications', false, true, false, false, false, []);
        $messageBody = json_encode($user);
        $message = new AMQPMessage($messageBody);
        $channel->basic_publish($message, '', 'notifications');
        $channel->close();
        $connection->close();
    }
}
