<?php

namespace MailCannon\Address;


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


    public function getId() : int 
    {

        return $this->int;
    }


    public function getUsername() : string 
    {

        return $this->username;
    }


    public function getDomain() : string 
    {

        return $this->domain;
    }
    

    public function getName() : string 
    {

        return $this->name;
    }
}
