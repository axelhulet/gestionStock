<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string',length: 50 , nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50,min: 2)]
    private $nom;

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Etat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }
    public function __toString(): string
    {
        return  $this->nom;
    }


}
