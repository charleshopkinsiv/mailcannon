<?php

namespace MailCannon\Message;

use MailCannon\Address\Address;
use MailCannon\AddressList\AddressList;
use MailCannon\Various\EncryptLite;
use MailCannon\Various\Registry;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MessageSender
{

    private static string $default_send_address = "newsletter@findonlinejobstoday.com";
    private static string $mail_log_file        = "/var/log/mail.log";

    private string $send_address, $mime_boundary, $unsub_base;

    public function __construct()
    {

        $this->send_address     = self::$default_send_address;
        $this->mime_boundary    = "MB7--------------------NC33999202934847398273";
        $this->unsub_base       = "https://findonlinejobstoday.com/unsubscribe";
        $this->dkim_key         = Registry::getConfig()['dkim']['private_key'] ?: "";
    }


    public function sendMessage(Message $message, Address $address)
    {

        $this->message = $message;
        $this->address = $address;

        $mail = new PHPMailer(true);

        try {

            // $recievers_address = $address->getToAddress();
            $mail->setFrom($this->send_address, "Online Earning");
            $mail->addAddress($address->getUsername() . "@" . $address->getDomain(), $address->getName());

            if(!empty($this->dkim_key)) {

                $mail->DKIM_domain          = explode("@", $this->send_address)[1];
                $mail->DKIM_private         = $this->dkim_key;
                $mail->DKIM_selector        = "phpmailer";
                $mail->DKIM_pasphrase       = "";
                $mail->DKIM_identity        = $mail->From;
            }

            $mail->isHTML(true);
            $mail->Subject      = $message->getSubject();
            $mail->Body         = $message->loadTemplate($this);
            $mail->AltBody      = "This is the plaintext";

            $mail->send();

            $reciept_date = date("M ") . str_pad(date("j"), 2, " ", STR_PAD_LEFT) . date(" H:i:s");
            $reciept = new MessageSendReciept($message, $address, $reciept_date);
            MessageLog::insertSend($reciept);

            return $reciept;
        }
        catch(Exception $e) {

            printf("Message Error: %s\n\n", $mail->ErrorInfo);
        }
    }


    public function getUnsubscribeLink()
    {

        $message = $this->address->getUsername() . "@" . $this->address->getDomain();
        $key = "allekjrj29k2j1e89778743874";

        return $this->unsub_base . "?key=" . urlencode(EncryptLite::encrypt($message, $key, true));
    }


    public function getMimeBoundary() : string { return "--" . $this->mime_boundary . "\n"; }


    public function sendMessageToList(Message $message, AddressList $list) : array
    {

        $reciepts = [];

        foreach($list->getAddresses() as $address) {

            $reciepts[] = $this->sendMessage($message, $address);
        }

        return $reciepts;
    }


    public function verifySend(MessageSendReciept $reciept) : bool
    {   // Scans Postfix logs for send

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
