<?php

namespace Source\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class Email // extends AnotherClass implements Interface
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
    public function __construct(array $MailAddress)
    {
        $this->mail = new PHPMailer();

        //Server settings
        $this->mail->isSMTP();
        // $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->CharSet = 'UTF-8';

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
        $this->mail->Host = gethostbyname("smtp.sendgrid.net");
        $this->mail->Port = "587";
        $this->mail->Username = "apikey";
        $this->mail->Password = "";
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';

        // no debug
        $this->mail->SMTPDebug = 3;

        // // full debug
        // $this->mail->SMTPDebug = 4;

        $this->mail->setFrom("contato@contato.com.br", 'TESTES');
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
        } catch (Exception $e) {
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
