<?php
use PHPUnit\Framework\TestCase;

use MailCannon\Various\Registry;
use MailCannon\Message\MessageSender;

final class SendMessageListTest extends TestCase
{

    public function testSendList(): void 
    {
        return;
        $message        =  Registry::getManagerFactory()->getManager("message")
                            ->getById(1);

        $address_list   =  Registry::getManagerFactory()->getManager("address_list")
                            ->getById(1);


        $address_one    =  Registry::getManagerFactory()->getManager("address")
                            ->getById(1);
        Registry::getManagerFactory()->getManager("address_list")
                            ->addAddressToList($address_list, $address_one);

        $address_two    =  Registry::getManagerFactory()->getManager("address")
                            ->getById(2);
        Registry::getManagerFactory()->getManager("address_list")
            ->addAddressToList($address_list, $address_two);

        $sender = new MessageSender();
        $send_reciepts = $sender->sendMessageToList($message, $address_list);
        $this->assertIsArray($send_reciepts);

        foreach($send_reciepts as $reciept) {

            $this->assertTrue(
                $sender->verifySend($reciept)
            );
        }

        Registry::getManagerFactory()->getManager("address_list")
            ->removeAddressFromList($address_list, $address_one);
        Registry::getManagerFactory()->getManager("address_list")
            ->removeAddressFromList($address_list, $address_two);
    }
}
