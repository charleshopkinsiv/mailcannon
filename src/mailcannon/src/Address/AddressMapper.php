<?php

namespace MailCannon\Address;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;


class AddressMapper extends SqlDataMapper
{

    protected string $table = "address";
    protected array $columns = [
        "username"  => "getUsername",
        "domain"    => "getDomain",
        "name"      => "getName"
    ];


    public function prepareObj(array $data) : DomainObject
    {

        return new Address(
            $data['id'],
            $data['username'],
            $data['domain'],
            $data['name']
        );
    }
}
