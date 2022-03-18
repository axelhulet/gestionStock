<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string', length: 10 , unique: true)]
    private $reference;

    #[ORM\Column(type: 'date' )]
    private $updateDate;

    #[ORM\Column(type: 'date' )]
    private $creationdate;


    #[ORM\ManyToOne(targetEntity: 'App\Entity\Etat')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION', nullable: false)]
    private $etat;

    //    cascade ['persist'] permet de sauvegarder une commande et un client en même temps
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Client')]
    #[ORM\JoinColumn(onDelete: 'NO ACTION', nullable: false)]
    private $client;

    /*
     * @var LigneCommande[]
     * */
    #[ORM\OneToMany(targetEntity: 'App\Entity\LigneCommande', mappedBy: 'commande')]
    private $lignes;

    /**
     * @param $lignes
     */
    public function __construct()
    {
        $this->lignes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * @param LigneCommande[] $lignes
     * @return Commande
     */
    public function setLignes($lignes)
    {
        $this->lignes = $lignes;
        return $this;
    }

    public function addLigne(LigneCommande $ligne){
        $this->lignes->add($ligne);
    }

    public function removeLigne(LigneCommande $ligne){
        $this->lignes->remove($ligne);
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return Commande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updateDate
     * @return Commande
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @param mixed $creationdate
     * @return Commande
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return Commande
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
