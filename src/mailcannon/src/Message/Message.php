<?php

namespace MailCannon\Address;


class Address extends DomainObject 
{

    private int $id;
    private string $subject, $template;

    public function __construct(int $id, string $subject, string $template)
    {

        $this->id           = $id;
        $this->subject      = $subject;
        $this->template     = $template;
    }


    public function getId() : int
    {

        return $this->id;
    }


    public function getSubject() : string
    {

        return $this->subject;
    }


    public function getTemplate() : string
    {

        return $this->template;
    }
}
