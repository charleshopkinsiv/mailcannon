<?php

use PHPUnit\Framework\TestCase;
use MailCannon\Address\Address;
use MailCannon\Various\Registry;


final class AddressTest extends TestCase
{

    public function testCreateAddress() : void 
    {

        $manager            = Registry::getManagerFactory()->getManager("address");
        $address            = new Address(0, "email_name", "test.com", "Test Name");
        $manager->create($address);

        $this->assertGreaterThan(0, $address->getId());
        $this->assertEquals($address, $manager->getById($address->getId()));

        $manager->delete($address);
    }


    public function testReadAddress() : void 
    {

        $manager         = Registry::getManagerFactory()->getManager("address");
        $address         = $manager->getById(1);
        $this->assertEquals($address->getId(), 1);
    }


    public function testUpdateAddress() : void 
    {

        $manager            = Registry::getManagerFactory()->getManager("address");
        $address            = new Address(0, "email_name", "test.com", "Test Name");
        $manager->create($address);

        $address->setUsername("email_name1");
        $address->setDomain("test1.com");
        $address->setName("Test Name1");
        $manager->update($address);

        $address            = $manager->getById($address->getId());
        $this->assertEquals($address->getUsername(), "email_name1");
        $this->assertEquals($address->getDomain(), "test1.com");
        $this->assertEquals($address->getName(), "Test Name1");

        $manager->delete($address);
    }


    public function testDeleteMessage() : void 
    {

        $manager        = Registry::getManagerFactory()->getManager("address");
        $address        = new Address(0, "email_name", "test.com", "Test Name");
        $manager->create($address);
        $new_address_id = $address->getId();
        $this->assertGreaterThan(0, $new_address_id);

        $manager->delete($address);

        $this->assertNull(
            $manager->getById($new_address_id)
        );
    }
}
