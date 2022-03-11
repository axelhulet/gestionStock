<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 8 , unique: true)]
    private $reference;

    #[ORM\Column(type: 'string', length: 50 )]
    private $nom;

    #[ORM\Column(type: 'text', length: 255 ,nullable: true)]
    private $description;

    #[ORM\Column(type: 'decimal', precision: 7, scale: 2 )]
    private $prixNum;

    #[ORM\Column(type: 'integer' )]
    private $stock;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private $deleted;

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return Produit
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Produit
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getPrixNum()
    {
        return $this->prixNum;
    }

    /**
     * @param mixed $prixNum
     * @return Produit
     */
    public function setPrixNum($prixNum)
    {
        $this->prixNum = $prixNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     * @return Produit
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     * @return Produit
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }
}
