<?php

namespace Core;


class Mail
{

    protected $from;
    protected $type;
    protected $encoding;

    public function __construct(string $from)
    {
        $this->from = $from;
        $this->type = 'text/html';
        $this->encoding = 'UTF-8';
    }

    public function setContentType(string $type)
    {
        $this->type = $type;
    }

    public function send($to, $subject, $message): bool
    {
        // Подготовка обратного темы.
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        //$prepMess = '=?utf-8?B?' . base64_encode($message) . '?=';

        // Добавление заголовков
        $headers = "From: {$this->from}\r\n"
            . "Reply-To: {$this->from}\r\n"
            . "Content-type: {$this->type}; charset={$this->encoding}\r\n";

        return mail($to, $subject, $message, $headers);
    }
}
