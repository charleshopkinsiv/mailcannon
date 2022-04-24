<?php

namespace MailCannon\Address;

use MailCannon\Various\DomainManager;

class AddressManager extends DomainManager 
{
    public function __construct()
    {

        $this->mapper = new AddressMapper();
    }
    
}
