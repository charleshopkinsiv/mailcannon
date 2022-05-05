<?php

namespace MailCannon\AddressList;

use MailCannon\Various\DomainManager;
use MailCannon\Address\Address;
use MailCannon\Address\AddressLazySet;


class AddressListManager extends DomainManager 
{

    public function __construct()
    {

        $this->mapper = new AddressListMapper();
    }


    public function getAddressesForList(AddressList $list) : AddressLazySet
    {

        return $this->mapper->getAddressesForList($list);
    }


    public function addAddressToList(AddressList $list, Address $address)
    {

        $this->mapper->addAddressToList($list, $address);
    }


    public function removeAddressFromList(AddressList $list, Address $address)
    {

        $this->mapper->removeAddressFromList($list, $address);
    }


    public function printAddressesForList(AddressList $list)
    {

        printf("\n\n%32s |%32s |%32s |\n", "Id", "Address Id", "Name");
        printf("%'-101s|\n", " ");

        $user_count = 0;
        foreach($this->mapper->getAddressesForList($list) as $address) {

            printf("%32s |%32s |%32s |\n", $address->getId(), $address->getUsername() . "@" . $address->getDomain(), $address->getName());
            $user_count++;
        }

        printf("%'-101s|\n\tUser Count: %d\n\n\n", " ", $user_count);
    }
}
