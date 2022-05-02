<?php

namespace MailCannon\Message;

use MailCannon\Address\Address;

class MessageSendReciept
{

    private Message $message;
    private Address $address;
    private string  $date;

    public function __construct(Message $message, Address $address, string $date)
    {

        $this->message = $message;
        $this->address = $address;
        $this->date    = $date;
    }

    public function getMessage() : Message { return $this->message; }
    public function getAddress() : Address { return $this->address; }
    public function getDate()    : string  { return $this->date; }
}
