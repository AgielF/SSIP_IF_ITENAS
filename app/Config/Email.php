<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail = 'noreply@gmail.com';
    public string $fromName  = 'Website Contact';
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';

    public string $protocol = 'smtp';

    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'agielnanda2004@gmail.com';
    public string $SMTPPass = 'hyppwxvubznxyrfo';
    public int    $SMTPPort = 587;
    public string $SMTPCrypto = 'tls';

    public int $SMTPTimeout = 10;
    public bool $SMTPKeepAlive = false;

    public string $mailType = 'html';
    public string $charset  = 'UTF-8';

    public bool $validate = true;
    public int  $priority = 3;

    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
}
