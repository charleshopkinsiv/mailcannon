<?php

namespace MailCannon\Various;


abstract class DomainObject 
{

    protected int $id;

    public function getId(): int
    {

        return $this->id;
    }
}