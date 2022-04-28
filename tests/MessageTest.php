<?php
// require __DIR__ . "/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use MailCannon\Message\Message;
use MailCannon\Various\Registry;


final class MessageTest extends TestCase
{

    private static string $subject_orig     = "Test";
    private static string $subject_append   = "1";

    private Message $message;

    public function testCreateMessage(): void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $this->message  = new Message(0, "Test", self::$subject_orig);
        $manager->insert($this->message);

        $this->assertGreaterThan(0, $this->message->getId);

        $this->assertEquals($this->message, $manager->getById($this->message->getId()));
    }


    public function testReadMessage(): void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $message        = $manager->getById($this->message->getId());
        $this->assertEquals($message, $this->message);
    }


    public function testUpdateMessage(): void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $message        = $manager->getById($this->message->getId());

        $message->setSubject(self::$subject_orig . self::$subject_append);
        $manager->insert($message);

        $message        = $manager->getById($this->message->getId());
        $this->assertEquals($message->getSubject(), self::$subject_orig . self::$subject_append);
    }


    public function testDeleteMessage(): void 
    {

        $manager         = Registry::getManagerFactory()->getManager("message");
        $manager->delete($this->message);

        $this->assertNull(
            $manager->getById($this->message->getId())
        );
    }
}
