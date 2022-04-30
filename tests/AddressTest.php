<?php

use PHPUnit\Framework\TestCase;
use MailCannon\Address\Address;
use MailCannon\Various\Registry;


final class AddressTest extends TestCase
{

    public function testCreateAddress() : void 
    {

        $manager         = Registry::getManagerFactory()->getManager("address");
        $address  = new Address(0, "email_name", "test.com", "Test Name");
        $manager->create($address);

        $this->assertGreaterThan(0, $address->getId());

        $this->assertEquals($address, $manager->getById($address->getId()));
    }


    public function testReadMessage() : void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $message         = $manager->getById(1);
        $this->assertEquals($message->getId(), 1);
    }


    public function testUpdateMessage() : void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $message  = new Message(0, "Test", self::$subject_orig);
        $manager->create($message);

        $message->setSubject(self::$subject_orig . self::$subject_append);
        $manager->update($message);

        $message        = $manager->getById($message->getId());
        $this->assertEquals($message->getSubject(), self::$subject_orig . self::$subject_append);
    }


    public function testDeleteMessage() : void 
    {

        $manager        = Registry::getManagerFactory()->getManager("message");
        $message        = new Message(0, "Test", self::$subject_orig);
        $manager->create($message);
        $new_message_id = $message->getId();
        $this->assertGreaterThan(0, $new_message_id);


        $manager->delete($message);

        $this->assertNull(
            $manager->getById($new_message_id)
        );
    }
}
