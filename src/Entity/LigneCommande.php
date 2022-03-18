<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\Column(type: 'decimal', precision: 7, scale: 2,nullable: true )]
    private $prix;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Commande', inversedBy: 'lignes')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION', nullable: false)]
    private $commande;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Produit')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION', nullable: false)]
    private $produit;

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     * @return LigneCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     * @return LigneCommande
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     * @return LigneCommande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     * @return LigneCommande
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function serialize(){
        $prix = $this->prix ?: $this->getProduit()->getPrixNum();
        return [
            'id' => $this->id,
            'quantite' => $this->quantite * 1,
            'prix' => $prix * 1,
            'prixTotal' => ($prix * $this->quantite),
            'produitRef' => $this->getProduit()->getReference()
        ];
    }
}
