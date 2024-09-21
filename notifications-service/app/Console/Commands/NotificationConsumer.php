<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class NotificationConsumer extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume notifications from message bus';

    /**
     * Execute the console command.
     */
    public function handle() {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('notifications', false, true, false, false, false, []);

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $this->logNotification($data);
        };

        $channel->basic_consume('notifications', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    private function logNotification($data) {
        $logMessage = "User Created: " . json_encode($data) . "\n";
        file_put_contents(storage_path('logs/notifications.log'));
    }
}
