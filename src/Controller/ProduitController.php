<?php
namespace App\Controller;

use App\Entity\Produit;
use App\Form\AddProduitType;
use App\Form\EditProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController {

    #[Route('/produit', name: 'produit')]
    public function index(Request $request, ProduitRepository $repo): Response{
        $produits = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 2,
            $request->query->get('keyword'));

        $total = $repo->countBySearch($request->query->get('keyword'));

        return $this->render('produit/index.html.twig', [
            'tableauProduit' => $produits,
            'total' => $total,
        ]);    }
    #[Route('/produit/add', name: 'produit_add')]
    public function add(Request $request, EntityManagerInterface $em, ProduitRepository $repo){
        $produit = new Produit();
        $form = $this->createForm(AddProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ref = substr($produit->getNom(),0, 3);

            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count, 4, '0',STR_PAD_LEFT ));
            $ref = strtoupper($ref);

            $produit->setReference($ref);
            $produit->setDeleted(false);
//            enregistrement local des changements
            $em->persist($produit);
//            sauvegarde dans la db
//            suppression d'un client
//            $em->remove($client);
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/produit/delete/{id}', name: 'produit_delete')]
    public function delete( $id, EntityManagerInterface $em,ProduitRepository $repo){
        $produit = $repo->find($id);
        if ($produit === null || $produit->getDeleted()){
            throw new NotFoundHttpException();
        }
        $produit->setDeleted(true);
        $em->flush();
        $this->addFlash('success','suppression OK');

        return $this->redirectToRoute('produit');
    }
    #[Route('/produit/update/{id}', name: 'produit_update')]
    public function update($id, Request $request, EntityManagerInterface $em,ProduitRepository $repo){

        $produit = $repo->find($id);
        $form = $this->createForm(EditProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($form);
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success','modification OK');
            return $this->redirectToRoute('produit');
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit
        ]);
    }

    #[Route('produit/search', name: 'produit_search')]
    public function getByName(Request $request, ProduitRepository $repo)
    {
        $name = $request->query->get('name');
        $products = $repo->findByName($name);

        return new JsonResponse(
            array_map(
                function ($item) {return $item->serialize();},
                $products
            )
        );
    }

}