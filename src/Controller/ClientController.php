<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\AddClientType;
use App\Form\EditClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/add', name: 'client_add')]
    public function add(Request $request, EntityManagerInterface $em, ClientRepository $repo){
        $client = new Client();
        $form = $this->createForm(AddClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($client->getNom(),0, 2);
            $ref .= substr($client->getPrenom(), 0, 2);
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count, 4, '0',STR_PAD_LEFT ));
            $ref = strtoupper($ref);

            $client->setReference($ref);
            $client->setDeleted(false);
//            enregistrement local des changements
            $em->persist($client);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('client');
        }

        return $this->render('client/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/client', name: 'client')]
    public function index(Request $request, ClientRepository $repo): Response
    {
        /*$clients =$repo->findBy([
            'deleted' => false,
            'nom' => 'Ly'
        ]);*/
        $clients = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 2,
            $request->query->get('keyword'));

        $total = $repo->countBySearch($request->query->get('keyword'));

        return $this->render('client/index.html.twig', [
            'tableauClients' => $clients,
            'total' => $total,
        ]);
    }

    #[Route('/client/delete/{id}', name: 'client_delete')]
    public function delete( $id, EntityManagerInterface $em,ClientRepository $repo){
        $client = $repo->find($id);
        if ($client === null || $client->getDeleted()){
            throw new NotFoundHttpException();
        }
        $client->setDeleted(true);
        $em->flush();
        $this->addFlash('success','suppression OK');

        return $this->redirectToRoute('client');
    }
    #[Route('/client/update/{id}', name: 'client_update')]
    public function update($id, Request $request, EntityManagerInterface $em,ClientRepository $repo){

        $client = $repo->find($id);
        if($client == null || $client->getDeleted()){
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(EditClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($form);
            $em->persist($client);
            $em->flush();
            $this->addFlash('success','modification OK');
            return $this->redirectToRoute('client');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client
        ]);    }

}
