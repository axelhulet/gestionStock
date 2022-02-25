<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendMailController extends AbstractController
{
    #[Route('/send_mail', name: 'send_mail')]
    public function sendMail(MailerInterface $mailer): Response
    {
        $mail =   (new Email())
        ->from('noreply.bformation@gmail.com')
        ->to('axelhulet@gmail.com')
        ->subject('test_mail')
        ->text('test d envoi d un mail');

        $mailer->send($mail);

      return $this->render('default/home.html.twig');
    }
}