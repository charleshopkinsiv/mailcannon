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

        // Front Controller

            // Http request if http

            // Check if command line -> replace wiht CmdRequest
            $controller = new CmdController(new self());
            $controller->run();
    }
}
