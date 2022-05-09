<?php

namespace MailCannon\Message;

use MailCannon\Various\Registry;

class MessageLog
{

    public static function insertSend(MessageSendReciept $reciept)
    {

        $sql = "INSERT INTO send_log 
                SET address = " . $reciept->getAddress()->getId() . ",
                    message = " . $reciept->getMessage()->getId();

        Registry::getDb()->query($sql)->execute();
    }


    public static function checkPastSend(Message $message, Address $address, int $days_back = 30) : bool
    {

        $sql = "SELECT COUNT(*) FROM send_log 
                WHERE address = " . $address->getId() . " AND message = " . $message->getId() . " 
                    AND datetime_sent >= DATE_SUB(NOW(), INTERVAL " . $days_back . " DAYS)";
        if(Registry::getDb()->query($sql)->single()['COUNT(*)'])
            return true;

        return false;
    }
}
