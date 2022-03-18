<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home')]
    public function home(Request $request): Response
    {
        // $request->query contient tous les paramètres "GET"
        // $request->query;
        //contient tous les contient tous les paramètres "POST" <=> $_POST
        // $request->request;
        //contient tous les contient tous les paramètres "SESSION" <=> $_SESSION
        // $request->getSession();
        // permet de récupérer la valeur de $_GET['name']
        $name = $request->query->get('name');
        dump($name);
        return $this->render('default/home.html.twig');
    }

    #[Route('/secured', name: 'app_home_secured')]
    public function secureAction(): Response
    {
        $user = $this->getUser();

        return $this->render('default/secured.html.twig', [
            'user' => $user
        ]);
    }

    #[Route(path: '/contact/{id}',
        name: 'default_contact',
        requirements: [
        //id doit être un nombre
        'id' => '\d+?'
        ], defaults: [
        'id' => 1
        ]
    )]
    public function contact(int $id) {
        if ($id === 1) {
            $model = 'Khun';
        }else if($id === 2){
            $model = 'Flavian';
        }else{
            // declencher une erreur 404
            throw new  NotFoundHttpException();
        }
        return $this->render('default/contact.html.twig', [
            'model' => $model
        ]);
    }

    #[Route(path: '/contact_us', name: 'default_contact_us')]
    public function contactUs(Request $request, MailerInterface $mailer) {
    //récupération des données en POST (ne pas utiliser cette manière mais passer par formType
        //$email = $request->request->get('email');
        //$message = $request->request->get('message');
        //creation d'un message vide
        $message = new Message();
//        dump($message);
        //methode qui permet de créer un formulaire
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $email = new  Email();
            $email->to('axelhulet@gmail.com');
            $email->from('noreply.bformation@gmail.com');
            $email->subject(sprintf(
                "l'utilisateur %s vous a envoyé un message",
                $message->getEmail()
            ));
//            $email->html(sprintf("<p>%s</p>", $message->getMessage()));
            $email->html($this->renderView('mail/contact_us.html.twig',['model' => $message]));
            try {
                $mailer->send($email);
                $this->addFlash('success', 'votre message a bien été envoyé');
            } catch (TransportExceptionInterface){
                $this->addFlash('error', 'une erreur est survenue, veuillez nous en excuser');
            }
            return $this->redirectToRoute('default_contact_us');
        }

//        dump($message);
        return $this->render('default/contact_us.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
