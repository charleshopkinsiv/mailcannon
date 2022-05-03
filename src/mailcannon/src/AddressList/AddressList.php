<?php

namespace MailCannon\AddressList;

use MailCannon\Various\DomainObject;
use MailCannon\Address\AddressLazySet;
use MailCannon\Various\Registry;

class AddressList extends DomainObject 
{

    protected int $id;
    private string $name;
    private AddressSet $adresses;

    public function __construct(int $id, string $name = "")
    {

        $this->id           = $id;
        $this->name         = $name;
    }


    public function getId() : int { return $this->id; }

    public function getName() : string              { return $this->name; }
    public function setName(string $name)           { $this->name = $name; }


    public function getAddresses() : AddressLazySet
    {

        if(empty($this->addresses)) {

            $this->addresses = Registry::getManagerFactory()
                                ->getManager("address_list")->getAddressesForList($this);
        }

        return $this->addresses;
    }
}
