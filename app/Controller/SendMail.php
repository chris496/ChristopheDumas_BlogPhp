<?php

namespace App\blog\Controller;

use PHPMailer\PHPMailer\SMTP;
use App\blog\Model\PostManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendMail extends Controller
{
    public function sendMail($lastname, $firstname, $email, $description)
    {
        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $lastname = htmlspecialchars($lastname);
        $firstname = htmlspecialchars($firstname);
        $email = htmlspecialchars($email);
        $description = htmlspecialchars($description);

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($description)) {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            if (preg_match($pattern, $lastname) && preg_match($pattern, $firstname) && preg_match($patternEmail, $email)) {
                $mail = new PHPMailer(true);
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'administrateur@p2.christophedumas1.fr';
                $mail->Password   = 'Hostingertit@496';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //Recipients
                $mail->setFrom('administrateur@p2.christophedumas1.fr', 'BlogPHP');
                $mail->addAddress('administrateur@p2.christophedumas1.fr');
                $mail->addReplyTo($email, 'Adresse mail du contact');

                //Content
                $mail->isHTML(true);
                $mail->Subject = $lastname . ' ' . $firstname;
                $mail->Body    = $description;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if (!$mail->send()) {
                    $this->twig->display('index.html.twig', [
                        'posts' => $posts,
                        'sendHs' => true
                    ]);
                } else {
                    $this->twig->display('index.html.twig', [
                        'posts' => $posts,
                        'sendOk' => true
                    ]);
                }
            }
        } else {
            $this->twig->display('index.html.twig', [
                'posts' => $posts,
                'vide' => true
            ]);
        }
    }
}
