<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\AddCommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function index(Request $request, CommandeRepository $repo): Response
    {
        $commandes = $repo->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes
        ]);
    }
    #[Route('/commande/add', name: 'commande_add')]
    public function add(Request $request, EntityManagerInterface $em, CommandeRepository $repo): Response
    {
        $commande = new Commande();
        $form = $this->createForm(AddCommandeType::class, $commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $ref = date('ymd');
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count, 4, '0',STR_PAD_LEFT ));
dump($form);
            $commande->setClient($form->get('client')->getData());
            $commande->setReference($ref);
            $commande->setUpdateDate(new \DateTime('now'));
            $commande->setCreationdate(new \DateTime('now'));
            $commande->setEtat(0);
dump($commande);
//            enregistrement local des changements
            $em->persist($commande);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('commande');
        }
        return $this->render('commande/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/commande/update', name: 'commande_update')]
public function update() : Response {
        return $this->render('commande/edit.html.twig', [

        ]);
    }

}
