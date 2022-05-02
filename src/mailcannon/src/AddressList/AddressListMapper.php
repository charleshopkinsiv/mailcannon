<?php

namespace MailCannon\AddressList;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;


class AddressListMapper extends SqlDataMapper
{

    protected string $table = "address_list";
    protected array $columns = [
        "name" => "getName"
    ];


    public function prepareObj(array $data) : DomainObject
    {

        return new AddressList(
            $data['id'],
            $data['name']
        );
    }
}
