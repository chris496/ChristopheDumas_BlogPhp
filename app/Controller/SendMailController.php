<?php

namespace App\blog\Controller;

use App\blog\SuperGlobals;
use PHPMailer\PHPMailer\SMTP;
use App\blog\Model\PostManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Dotenv\Dotenv;

class SendMailController extends Controller
{
    public function sendMail($lastname, $firstname, $email, $description)
    {
        $user = $this->isAdmin();

        $dotenv = new Dotenv();   
        $dotenv->load(dirname(__FILE__,3) . '/.env');
        
        $superglobals = new SuperGlobals();
        $env = $superglobals->getENV();

        $postsManager = new PostManager();
        $posts = $postsManager->getPosts();

        $lastname = htmlspecialchars($lastname);
        $firstname = htmlspecialchars($firstname);
        $email = htmlspecialchars($email);
        $description = htmlspecialchars($description);

        $url_slug = $this->UrlSlug();

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($description)) {
            $pattern = '/^(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/';
            $patternEmail = '/.+\@.+\..+/';
            if (preg_match($pattern, $lastname) && preg_match($pattern, $firstname) && preg_match($patternEmail, $email)) {
                $mail = new PHPMailer(true);
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = $env['MAIL_HOST'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $env['MAIL_USERNAME'];
                $mail->Password   = $env['MAIL_PASSWORD'];
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
                $mail->setFrom($env['MAIL_USERNAME'], 'BlogPHP');
                $mail->addAddress($env['MAIL_USERNAME']);
                $mail->addReplyTo($email, 'Adresse mail du contact');

                //Content
                $mail->isHTML(true);
                $mail->Subject = $lastname . ' ' . $firstname;
                $mail->Body    = $description;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if (!$mail->send()) {
                    return $this->twig->display('index.html.twig', [
                        'posts' => $posts,
                        'sendHs' => true,
                        'url' => $url_slug,
                        'user' => $user
                    ]);
                }
                return $this->twig->display('index.html.twig', [
                    'posts' => $posts,
                    'sendOk' => true,
                    'url' => $url_slug,
                    'user' => $user
                ]);
            }
        }
        return $this->twig->display('index.html.twig', [
            'posts' => $posts,
            'vide' => true,
            'url' => $url_slug,
            'user' => $user
        ]);
    }
}
