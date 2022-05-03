<?php

namespace MailCannon\Message;

use MailCannon\Address\Address;
use MailCannon\AddressList\AddressList;

class MessageSender
{

    private static string $default_send_address = "newsletter@findonlinejobstoday.com";
    private static string $mail_log_file        = "/var/log/mail.log";

    private string $send_address;

    public function __construct()
    {

        $this->send_address = self::$default_send_address;
    }


    public function sendMessage(Message $message, Address $address)
    {

        $recievers_address = $address->getToAddress();

        if(mail(
            $recievers_address,
            $message->getSubject(),
            $message->loadTemplate(),
            [
                "From"              => $this->send_address,
                "Reply-To"          => $this->send_address,
                "MIME-Version"      => "1.0",
                "Content-Type"      => "text/html"
            ]
        )) {

            $reciept_date = date("M ") . str_pad(date("j"), 2, " ", STR_PAD_LEFT) . date(" H:i:s");

            return new MessageSendReciept($message, $address, $reciept_date);
        }
    }


    public function sendMessageToList(Message $message, AddressList $list) : array
    {

        $reciepts = [];

        foreach($list->getAddresses() as $address) {

            $reciepts[] = $this->sendMessage($message, $address);
        }

        return $reciepts;
    }


    public function verifySend(MessageSendReciept $reciept) : bool
    {

        $max_retries = 5;
        $sleep_between_retries = 3;
        $max_rows_to_check = 20;

        for($i = 0; $i < $max_retries; $i++) {

            $file = file(self::$mail_log_file);
        
            $counter = 0;
            while($counter < $max_rows_to_check) {
    
                $counter++;
                $row = $file[count($file) - $counter];
                $search_date = substr($reciept->getDate(), 0, strlen($reciept->getDate()) - 1);
                $log_dates = [];
                preg_match("/(\w{3}\s[\s\d]{2}\s\d{2}:\d{2}:\d{2})/", $row, $log_dates);

                $sliced_log_date = substr($log_dates[0], 0, strlen($log_dates[0]) - 1);
                if($sliced_log_date < $search_date){
                    
                    break;
                }
                    
                $to_address = $reciept->getAddress()->getUsername() . "@" . $reciept->getAddress()->getDomain();
                if(preg_match("/" . $to_address . "/", $row)
                && preg_match("/to=/", $row)
                && preg_match("/status=sent/", $row)) {

                    return true;
                }
            }

            sleep($sleep_between_retries);
        }

        return false;
    }
}