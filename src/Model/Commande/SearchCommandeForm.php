<?php

namespace App\Model\Commande;

use App\Entity\Client;
use App\Entity\Etat;

class SearchCommandeForm
{
    public ?string $reference = null;
    public Client|null $client = null;
    public ?\DateTime $startAt = null;
    public ?\DateTime $endAt = null;
    public Etat|null $etats = null;
}