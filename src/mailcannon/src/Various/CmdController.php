<?php

namespace MailCannon\Various;

use MailCannon\MailCannon;


class CmdController
{

    private MailCannon  $mail_cannon;
    private bool        $running = true;


    public function __construct(MailCannon $mail_cannon)
    {

        $this->mail_cannon = $mail_cannon;
    }


    public function run()
    {

        printf("Welcome to MailCannon\n\n");
        self::printOptions();

        while($this->running) {

            $this->handleCommand();
        }
    }


    public static function printOptions()
    {

        printf("\t- Make a selection below. . .\n");
        printf("\t1 - Send Message to Address\n");
        printf("\t2 - Send Message to Address List\n");
        printf("\t3 - Message Manager\n");
        printf("\t4 - Address Manager\n");
        printf("\t5 - Address List Manager\n");
        printf("\t6 - Send Log\n");
    }


    public function getCmdLine()
    {
        
        $handle = fopen("php://stdin","r");
        $line = trim(fgets($handle));
        return $line;
    }


    public function handleCommand()
    {

        switch($this->getCmdLine()) {

            case 1:
                $this->sendMessageToAddress();
                break;
            case 2:
                $this->sendMessageToAddressList();
                break;
            case 3;
                $this->messageManager();
                break;
            case 4; 
                $this->addressManager();
                break;
            case 5;
                $this->addressListManager();
                break;
            case 6;
                $this->sendLog();
                break;
        }
    }


    public function sendMessageToAddress()
    {
      
        while(true) {

            printf("\nEnter email address or address id to send to\n");

            $line = $this->getCmdLine();
            if(is_int($line)) {

                $account = Registry::getManagerFactory("account")->getById($line);
                break;
            }
            elseif(filter_var($line, FILTER_VALIDATE_EMAIL)) {

                $account = Registry::getManagerFactory("account")->getByAddress($line);
                try {


                }
                catch(\Exception $e) {

                    //  Create Account
                    //  
                    // Registry::getManagerFactory("account")->insert(
                    //     new Account(
                    //         0,

                    //     )
                    // );
                }
                break;
            }
            else {

                printf("\nBad entry. . .\n");
            }
        }


        while(true) {

            printf("\nEnter message id. . .");

            $line = $this->getCmdLine();
            if(is_int($line)) {

                $account = Registry::getManagerFactory("account_list")->getById($line);
                break;
            }
            else {

                printf("\nBad entry. . .\n");
            }
        }
    }
}