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
}
