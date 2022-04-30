<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainManager;


class MessageManager extends DomainManager 
{

    public function __construct()
    {

        $this->mapper = new MessageMapper();
    }
}
