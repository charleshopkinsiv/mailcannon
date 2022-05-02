<?php

namespace MailCannon\Address;

use MailCannon\Various\DomainObject;

class Address extends DomainObject 
{

    protected int $id;
    private string $username, $domain, $name;

    public function __construct(int $id, string $username, string $domain, string $name = "")
    {

        $this->id           = $id;
        $this->username     = $username;
        $this->domain       = $domain;
        $this->name         = $name;
    }


    public function getId() : int { return $this->id; }

    public function getUsername() : string          { return $this->username; }
    public function setUsername(string $username)   { $this->username = $username; }

    public function getDomain() : string            { return $this->domain; }
    public function setDomain(string $domain)       { $this->domain = $domain; }

    public function getName() : string              { return $this->name; }
    public function setName(string $name)           { $this->name = $name; }


    public function getToAddress()
    {
        
        return ($this->name ?: $this->username)  . " <" . $this->username . "@" . $this->domain . ">";
    }
}
