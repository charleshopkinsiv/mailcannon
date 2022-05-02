<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainObject;

class Message extends DomainObject 
{

    protected int $id;
    private string $subject, $template;

    public function __construct(int $id, string $subject, string $template)
    {

        $this->id           = $id;
        $this->subject      = $subject;
        $this->template     = $template;
    }


    public function getId() : int { return $this->id; }


    public function getSubject() : string { return $this->subject; }
    public function setSubject(string $subject) { $this->subject = $subject; }

    
    public function getTemplate() : string { return $this->template; }
    public function setTemplate(string $template) { $this->template = $template; }

    
    public function loadTemplate()
    {

        return file_get_contents(__DIR__ . "/../../../../templates/" . $this->template);
    }
}
