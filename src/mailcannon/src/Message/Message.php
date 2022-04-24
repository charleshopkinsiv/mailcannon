<?php

namespace MailCannon\Address;


class Address extends DomainObject 
{

    private int $id;
    private string $subject, $template;

    public function __construct($id, $subject, $template)
    {


    }
}
