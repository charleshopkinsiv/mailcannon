<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;


class MessageMapper extends SqlDataMapper
{

    protected string $table = "message";
    protected array $columns = [
        "subject" => "getSubject",
        "template" => "getTemplate"
    ];


    public function prepareObj(array $data) : DomainObject
    {

        return new Message(
            $data['id'],
            $data['subject'],
            $data['template']
        );
    }
}
