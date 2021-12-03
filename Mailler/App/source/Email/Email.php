<?php

namespace Source\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class Email
{
    /**
     * @var PHPMailer\PHPMailer\PHPMailer $mail
     */
    private $mail;

    /**
     * @var string $error
     */
    private $error;

    /**
     * @param array $MailAddress
     */
    public function __construct(array $MailAddress, bool $html = true)
    {
        $this->mail = new PHPMailer();

        // SMTP Server settings
        if (CONF_MAIL_OPTION_SMTP === true) {
            $this->mail->isSMTP();
        }

        if ($html === true) {
            $this->mail->isHTML();
        }

        $this->mail->setLanguage(CONF_MAIL_OPTION_LANG);

        $this->mail->CharSet = CONF_MAIL_OPTION_CHARSET;

        $this->setConfig();

        //Recipients
        foreach ($MailAddress as $key => $mail) {
            $this->mail->addAddress($mail);
        }
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return void
     */
    private function setConfig(): void
    {
        $this->mail->Host = gethostbyname(CONF_MAIL_HOST);
        $this->mail->Port = CONF_MAIL_PORT;
        $this->mail->Username = CONF_MAIL_USER;
        $this->mail->Password = getenv('MAIL_PASS') ?? '';
        $this->mail->SMTPAuth = CONF_MAIL_OPTION_AUTH;
        $this->mail->SMTPSecure = CONF_MAIL_OPTION_SECURE;

        // Debug off
        $this->mail->SMTPDebug = 0;

        // Debug on
        // $this->mail->SMTPDebug = 4;

        $this->mail->setFrom(CONF_MAIL_SENDER['address'], CONF_MAIL_SENDER['name']);
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }
    
    /**
     * @param string $MailBody
     * @param string $customer
     * @return bool
     */
    public function SendMail(string $MailBody, string $Subject): bool
    {
        try {
            // Content
            $this->mail->Subject = $Subject;
            $this->mail->Body = $MailBody;
            $this->mail->AltBody = $Subject;
        
            if (!$this->mail->send()) {
                $this->error = $this->mail->ErrorInfo;
                return false;
            }

            return true;
        } catch (\Exception $e) {
            \writeLog($e->getMessage());
            \writeLog($this->mail->ErrorInfo);

            $this->error = $this->mail->ErrorInfo;
            return false;
        }
    }

    /**
     * @return void
     */
    public function clearAddresses(): void
    {
        $this->mail->ClearAddresses();
    }
}

