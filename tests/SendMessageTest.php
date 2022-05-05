<?php

use PHPUnit\Framework\TestCase;
use MailCannon\Various\Registry;
use MailCannon\Message\MessageSender;


final class SendMessageTest extends TestCase
{

    public function testSend(): void 
    {
        // return;
        $message =  Registry::getManagerFactory()->getManager("message")
                        ->getById(1);
                                
        $address =  Registry::getManagerFactory()->getManager("address")
                        ->getById(1);

        $sender = new MessageSender();
        $send_reciept = $sender->sendMessage($message, $address);
        $this->assertInstanceOf("MailCannon\\Message\\MessageSendReciept", $send_reciept);

        $this->assertTrue( // Verify that the email was sent, check mail.log
            $sender->verifySend($send_reciept)
        );
    }
}
