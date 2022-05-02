<?php

namespace MailCannon\AddressList;

use MailCannon\Various\DomainManager;


class AddressListManager extends DomainManager 
{

    public function __construct()
    {

        $this->mapper = new AddressListMapper();
    }
}
