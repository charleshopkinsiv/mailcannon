<?php
use PHPUnit\Framework\TestCase;
use MailCannon\AddressList\AddressList;
use MailCannon\Various\Registry;

final class AddressListTest extends TestCase
{

    public function testCreateAddressList() : void 
    {

        $manager            = Registry::getManagerFactory()->getManager("address_list");
        $address_list       = new AddressList(0, "test");
        $manager->create($address_list);

        $this->assertGreaterThan(0, $address_list->getId());
        $this->assertEquals($address_list, $manager->getById($address_list->getId()));

        $manager->delete($address_list);
    }


    public function testReadAddressList() : void 
    {

        $manager         = Registry::getManagerFactory()->getManager("address_list");
        $address_list    = $manager->getById(1);
        $this->assertEquals($address_list->getId(), 1);
    }


    public function testUpdateAddressList() : void 
    {

        $manager            = Registry::getManagerFactory()->getManager("address_list");
        $address_list       = new AddressList(0, "test");
        $manager->create($address_list);

        $address_list->setName("test1");
        $manager->update($address_list);

        $address_list       = $manager->getById($address_list->getId());
        $this->assertEquals($address_list->getName(), "test1");

        $manager->delete($address_list);
    }


    public function testDeleteAddressList() : void 
    {

        $manager        = Registry::getManagerFactory()->getManager("address_list");
        $address_list   = new AddressList(0, "test");
        $manager->create($address_list);
        $new_address_list_id = $address_list->getId();
        $this->assertGreaterThan(0, $new_address_list_id);

        $manager->delete($address_list);

        $this->assertNull(
            $manager->getById($new_address_list_id)
        );
    }


    public function testAddressListLinks() : void 
    {

        // Add user to list
        $manager         = Registry::getManagerFactory()->getManager("address_list");
        $address_list    = $manager->getById(1);

        $address_manager = Registry::getManagerFactory()->getManager("address");
        $address         = $address_manager->getById(1);

        $manager->addAddressToList($address_list, $address);

        // Verify user is on list
        $in_list = false;
        foreach($manager->getAddressesForList($address_list) as $address_fr_list) {

            if($address_fr_list == $address) {

                $in_list = true;
                break;
            }
        }

        $this->assertTrue($in_list);


        // Remove user and verify removed
        $manager->removeAddressFromList($address_list, $address);

        $not_in_list = true;
        foreach($manager->getAddressesForList($address_list) as $address_fr_list) {

            if($address_fr_list == $address) {

                $not_in_list = false;
            }
        }

        $this->assertTrue($not_in_list);
    }
}
