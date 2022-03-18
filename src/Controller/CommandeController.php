<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\AddCommandeType;
use App\Form\EditCommandeType;
use App\Form\SearchCommandeType;
use App\Model\Commande\SearchCommandeForm;
use App\Repository\CommandeRepository;
use App\Repository\EtatRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function commande(Request $request, CommandeRepository $repo): \Symfony\Component\HttpFoundation\Response
    {

        //créer un objet SearchCommanForm
        $search = new SearchCommandeForm();


        $form= $this->createForm(SearchCommandeType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commandes = $repo->search($search->reference, $search->client, $search->startAt, $search->endAt, $search->etats);

        } else {
            $commandes = $repo->findAll();
        }

        return $this->render('commande/index.html.twig',[
            'commandes' => $commandes,
            'form' => $form->createView()
        ]);
    }
    #[Route('/commande/add', name: 'commande_add')]
    public function add(Request $request, EntityManagerInterface $em, CommandeRepository $repo, EtatRepository $repo2): Response
    {
        $commande = new Commande();
        $form = $this->createForm(AddCommandeType::class, $commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $ref = date('ymd');
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count, 4, '0',STR_PAD_LEFT ));
            $etat = $repo2->find(1);
//            $commande->setClient($form->get('client')->getData());
            $commande->setReference($ref);
            $commande->setUpdateDate(new \DateTime('now'));
            $commande->setCreationdate(new \DateTime('now'));
            $commande->setEtat($etat);
//            enregistrement local des changements
            $em->persist($commande);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('commande_update', ['id' => $commande->getId()]);
        }
        return $this->render('commande/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/commande/update/{id}', name: 'commande_update', requirements: ['id' => '\d+'])]
    public function update( Request $request, CommandeRepository $repo, int $id) : Response {

        $commande = $repo->findWithClient($id);
        $form = $this->createForm(EditCommandeType::class, $commande);
        $form->handleRequest($request);
        return $this->render('commande/edit.html.twig', [
            'form' => $form->createView(),
            'commandes' => $commande
        ]);
    }

    #[Route('/commande/add_line/{id}', name: 'commande_add_line')]
    public function ajouterLigne(
        $id,
        Request $request,
        EntityManagerInterface $em,
        CommandeRepository $repo,
        ProduitRepository $repo2,
        LigneCommandeRepository $repo3
    ) {
        //est-ce qu'il une commande liée a l'ID
        $commande = $repo->findWithLinesAndProducts($id);
        if ($commande === null) {
            throw new NotFoundHttpException(); //error404
        }
        if($commande->getEtat()->getNom() !== 'InProgress'){
            throw new BadRequestHttpException();
        }
        $produitId = $request->request->get('produitId');
        $quantity = $request->request->get('quantity');

        //chercher les lignes d'un tableau qui respecte une certaine condition
        $ligne = $repo3->findOneBy(['produit' => $produitId, 'commande' => $id]);

        $results = array_filter($commande->getLignes()->toArray(), function ($item) use ($produitId){
            return $item->getProduit()->getId() == $produitId;
        });
        if($ligne === null) {
            $ligne = new LigneCommande();
            $p = $repo2->findOneBy(['id' => $produitId, 'deleted' => false]);
            if ($p === null) {
                throw new BadRequestException(); //
            }
            $ligne->setProduit($p);
            $ligne->setQuantite($quantity);
            $ligne->setCommande($commande);
            $commande->addLigne($ligne);
            $em->persist($ligne);
            $em->flush();

        }else{
            $ligne->setQuantite($quantity);
            $em->flush();
        }

        return new JsonResponse(array_map(
            function ($item) {
                return $item->serialize();
            }, $commande->getLignes()->toArray()
        ));
    }

    #[Route('commandes/lines/{id}', name: 'commande_lines')]
    public function getLines($id, CommandeRepository $repo) {
        $commande = $repo->findWithLinesAndProducts($id);

        if($commande === null){
            throw new NotFoundHttpException();
        }
        return new JsonResponse(array_map(
            function ($item) {
                return $item->serialize();
            }, $commande->getLignes()->toArray()
        ));
    }

}
