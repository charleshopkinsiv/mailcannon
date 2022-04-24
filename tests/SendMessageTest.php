<?php

use PHPUnit\Framework\TestCase;
use MailCannon\Various\Registry;
use MailCannon\Message\MessageSender;


final class SendMessageTest extends TestCase
{

    public function testSend(): void 
    {
        
        $message =  Registry::getManagerFactory()->getManager("message")
                        ->loadById(1);
                                
        $address =  Registry::getManagerFactory()->getManager("address")
                        ->loadById(1);

        $sender = new MessageSender();
        $send_reciept = $sender->sendMessage($message, $address);

        $this->assertTrue( // Verify that the email was sent
            $sender->verifySends([$send_reciept])
        );
    }


    public function testReciept(): void 
    {

        // Log in to test $address on gmail and verify email was recieved
    }
}
