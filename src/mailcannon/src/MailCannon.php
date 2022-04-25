<?php

namespace MailCannon;

use MailCannon\Various\CmdController;

class MailCannon
{


    public function __construct()
    {


    }


    public static function main()
    {

        // Front controller if http

        // Check if command line
        $controller = new CmdController($this);
        $controller->run();
    }


    public function sendMessageToAddress()
    {


    }
}
