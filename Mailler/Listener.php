<?php

/* Remove the execution time limit */
set_time_limit(0); 

require __DIR__ . "/vendor/autoload.php";

/**
 * Exception
 */
use Source\Exception\InvalidArgumentException;

/**
 * RabbitMQ
 */
use Source\RabbitMQ\RabbitReceiver;
use Source\RabbitMQ\RabbitSender;

/**
 * Email
 */
use Source\Email\Email;

/**
 * Main listener for send emails
 * 
 * using the rabbitmq as a message broker
 * used protocol:
 * Advanced Message Queuing Protocol (AMQP)
 */
final class Listener extends RabbitReceiver
{
    /**
     * @var RabbitSender $RabbitSender
     */
    private $RabbitSender;

    /**
     * @var string $queue
     * @var string $exchanger
     */
    public function __construct(string $queue, string $exchanger)
    {
        $this->getInstance($queue, $exchanger)->consume();
    }

    /**
     * The handler of the messages received from queue
     * @var mixed $message Received from rabbitmq queue
     */
    protected function handler($receivedMessage)
    {
        $message = $receivedMessage->body;
        
        // echo "Message received: ";
        // print_r($message);
        // echo " - at: " . date("d/m/Y H:i");
        // echo "\n\n";

        // $this->RabbitSender = new RabbitSender('log', 'log');
        // $this->RabbitSender->sendMessage("Mensagem recebida!");

        try {
            switch ($message) {
                case "mail1":
                    $MailController = new Email([
                        "contato@outlook.com"
                    ]);

                    $subject = 'teste';
                    $body = 'teste';

                    if ($MailController->sendMail($body, $subject)) {
                        $handledMessage = true;
                    }
                    break;
    
                case "mail2":
                    $MailController = new Email([
                        "contato@outlook.com"
                    ]);

                    $subject = 'teste';
                    $body = 'teste';

                    if ($MailController->sendMail($body, $subject)) {
                        $handledMessage = true;
                    }
                    break;
                
                default:
                    echo "?";
                    break;
            }
        }
        catch (Throwable $exception) {
            // $this->Logger->log("Unexpected Error: {$exception->getMessage()} - exactly at line: {$exception->getLine()}", true);
            echo "Unexpected Error: {$exception->getMessage()} - exactly at line: {$exception->getLine()}\n\n";
        }
        finally {
            /**
             * Verify if the message are received and if yes, send the ack for the queue
             */
            if (!empty($handledMessage)) {
                // send ack for remove message from the queue
                $receivedMessage->delivery_info['channel']->basic_ack($receivedMessage->delivery_info['delivery_tag']);
                unset($handledMessage);
            } else {
                // return to the queue 
                $receivedMessage->delivery_info['channel']->basic_nack($receivedMessage->delivery_info['delivery_tag']);
            }
        }
    }
}

$queue = "email";
$exchanger = "email";

do {
    /**
     * nothing you write from here to down, dont will be run, because of the infinite listening loop
     */
    try {
        echo "Starting E-mail Service...\n";
        sleep(2);
        $RabbitReceiver = new Listener($queue, $exchanger);
    }
    catch (Throwable $exception) {
        // $this->Logger->log("Unexpected Error: {$exception->getMessage()} - exactly at line: {$exception->getLine()}", true);
        echo "Unexpect Error: {$exception->getMessage()} - at line: {$exception->getLine()} in {$exception->getFile()}\n\n";

        if (!empty($RabbitReceiver)) {
            unset($RabbitReceiver);
        }
        
        sleep(5);
        continue;
    }
} while (true);
