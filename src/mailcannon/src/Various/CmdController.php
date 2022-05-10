<?php
//
//  Make large then implement everything with a CmdInterface class
//  - SendEmailMessageToUser cmd input implemented in getCmdLine(string $text = "", array $types = [])

namespace MailCannon\Various;

use MailCannon\MailCannon;
use MailCannon\Message\MessageSender;
use MailCannon\Message\Message;
use MailCannon\Address\Address;
use MailCannon\AddressList\AddressList;


class CmdController
{

    private MailCannon  $mail_cannon;
    private bool        $running = true;


    private static $start_options = [
        "\t- Make a selection below\n",
        "\t1 - Send Message to Address\n",
        "\t2 - Send Message to Address List\n",
        "\t3 - Message Manager\n",
        "\t4 - Address Manager\n",
        "\t5 - Address List Manager\n",
        "\t6 - Send Log\n",
        "\t7 - Stats\n\n\t"
    ];

    private static $manager_options = [
        "\t1 - Create\n",
        "\t2 - List All\n",
        "\t3 - Update\n",
        "\t4 - Delete\n",
    ];


    public function __construct(MailCannon $mail_cannon)
    {

        $this->mail_cannon = $mail_cannon;
    }


    public function run()
    {

        printf("Welcome to MailCannon\n\n");
        $this->start();

        printf("Exiting. . \n\n");
        exit();
    }


    public function start()
    {
        while(true) {

            $this->handleCommand(self::printOptions(self::$start_options));
        }
    }


    public static function printOptions(array $options)
    {

        foreach($options as $line) {

            printf($line);
        }
    }


    public function getCmdLine(string $text = "")
    {
        
        if(!empty($text))
            printf("\t" . $text . "\t");

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
                $this->loadManager("message");
                break;
            case 4; 
                $this->loadManager("address");
                break;
            case 5;
                $this->loadManager("address_list");
                break;
            case 6;
                $this->sendLog();
                break;
        }
    }


    public function sendMessageToAddress()
    {
      
        while(true) {

            printf("Enter email address or address id to send to\n\t");

            $line = $this->getCmdLine();
            if(is_numeric($line)) {

                $address = Registry::getManagerFactory()->getManager("address")->getById($line);
                break;
            }
            elseif(filter_var($line, FILTER_VALIDATE_EMAIL)) {

                $address = new Address(0, explode("@", $line)[0], explode("@", $line)[1]);
                break;
            }
            else {

                printf("Bad entry. . .\n");
            }
        }


        while(true) {

            printf("Enter message id\n\t");

            $line = $this->getCmdLine();
            if(is_numeric($line)) {

                $message = Registry::getManagerFactory()->getManager("message")->getById($line);
                break;
            }
            else {

                printf("Bad entry. . .\n");
            }
        }

        $sender = new MessageSender;
        $send_reciept = $sender->sendMessage($message, $address);

        if($sender->verifySend($send_reciept)) {

            printf("Successful send\n\n\n");
        }
    }

    
    private function sendMessageToAddressList()
    {

        $address_list   = Registry::getManagerFactory()->getManager("address_list")
                            ->getById($this->getCmdLine("Address list id"));
        $message        = Registry::getManagerFactory()->getManager("message")
                            ->getById($this->getCmdLine("Message id"));

        $sender = new MessageSender;
        $send_reciepts = $sender->sendMessageToList(
            $message,
            $address_list
        );

        foreach($send_reciepts as $reciept) {

            if($sender->verifySend($reciept)) {

                printf("\tSuccessful send to %32s\n\n", $reciept->getAddress()->getUsername() . "@" . $reciept->getAddress()->getDomain());
            }
        }
    }


    private function loadManager(string $type)
    {

        printf("\t- %s Manager\n", $type);
        $options = self::$manager_options;

        if($type == "message")
            $options = array_merge($options, ["\t5 - List Templates\n"]);

        if($type == "address_list")
            $options = array_merge($options, ["\t5 - Add Address to List\n", "\t6 - List Addresses for List\n", "\t7 - Remove Address from List\n"]);

        self::printOptions($options);

        switch($this->getCmdLine()) {

            case 1:
                $obj = $this->loadObject($type);
                Registry::getManagerFactory()->getManager($type)
                    ->create($obj);
                return;
            case 2:
                Registry::getManagerFactory()->getManager($type)
                    ->printAll();
                return;
            case 3:
                Registry::getManagerFactory()->getManager($type)
                    ->update($this->loadUpdatedObject($type));
                return;
            case 4:
                $id = $this->getCmdLine(ucfirst($type) . " id to delete");
                Registry::getManagerFactory()->getManager($type)
                    ->delete(Registry::getManagerFactory()->getManager($type)
                        ->getById($id));
                return;

            case 5:

                if($type == "message") {

                    Registry::getManagerFactory()->getManager($type)->printTemplates();
                    return;
                }

                if($type == "address_list") {

                    $address_list   = $this->getCmdLine("Address list id");
                    $ids            = $this->getCmdLine("Address id's to add (Sep. Mult. by ,)\n\t");
                    foreach(explode(",", $ids) as $id) {
                            
                        $id = trim($id);
                        Registry::getManagerFactory()->getManager($type)->addAddressToList(
                            Registry::getManagerFactory()->getManager("address_list")
                                ->getById($address_list),
                            Registry::getManagerFactory()->getManager("address")
                                ->getById($id)
                        );
                    }
                    return;
                }

            case 6:
                if($type == "address_list") {

                    Registry::getManagerFactory()->getManager($type)->printAddressesForList(
                        Registry::getManagerFactory()->getManager("address_list")
                            ->getById($this->getCmdLine("Address list id"))
                        );
                    return;
                }

            case 7: 
                if($type == "address_list") {

                    $address_list   = $this->getCmdLine("Address list id");
                    $ids            = $this->getCmdLine("Address id's to remove from list (Sep. Mult. by ,)\n\t");
                    foreach(explode(",", $ids) as $id) {

                        $id = trim($id);
                        Registry::getManagerFactory()->getManager($type)->removeAddressFromList(
                            Registry::getManagerFactory()->getManager("address_list")
                                ->getById($address_list),
                            Registry::getManagerFactory()->getManager("address")
                                ->getById($id)
                        );
                    }

                    return;
                }
        }
    }


    private function loadObject(string $type)
    {

        switch($type) {

            case 'address':
                return new Address(
                    0,
                    $this->getCmdLine("Username <username>@"),
                    $this->getCmdLine("Hostname @<hostname>"),
                    $this->getCmdLine("Name")
                );
            case 'message':
                return new Message(
                    0,
                    $this->getCmdLine("Subject"),
                    $this->getCmdLine("Template")
                );
            case 'address_list':
                return new AddressList(
                    0,
                    $this->getCmdLine("Name")
                );
        }
    }


    private function loadUpdatedObject(string $type)
    {

        switch($type) {

            case 'address':
                $address = Registry::getManagerFactory()->getManager($type)
                    ->getById($this->getCmdLine("Address id"));
                $address->setUsername($this->getCmdLine("Username; " . $address->getUsername() . " = "));
                $address->setDomain($this->getCmdLine("Domain; " . $address->getDomain() . " = "));
                $address->setName($this->getCmdLine("Name; " . $address->getName() . " = "));
                return $address;
            case 'message':
                $message = Registry::getManagerFactory()->getManager($type)
                    ->getById($this->getCmdLine("Message id"));
                $message->setSubject($this->getCmdLine("Subject; " . $message->getSubject() . " = "));
                $message->setTemplate($this->getCmdLine("Template; " . $message->getTemplate() . " = "));
                return $message;
            case 'address_list':
                $address_list = Registry::getManagerFactory()->getManager($type)
                    ->getById($this->getCmdLine("Message id"));
                $address_list->setSubject($this->getCmdLine("Name; " . $address_list->getName() . " = "));
                return $address_list;
        }
    }
}
