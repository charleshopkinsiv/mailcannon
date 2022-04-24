<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainManager;
use MailCannon\Various\DomainObject;

class MessageManager extends DomainManager 
{

    public function __construct()
    {

        $this->mapper = new MessageMapper();
    }
}
