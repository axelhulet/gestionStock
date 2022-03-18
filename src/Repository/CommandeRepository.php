<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function countByRef($ref)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.reference LIKE :p1');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
    public function findBySearch($offset, $limit, $keyword) {

        $qb = $this->_getQbWithSearch($keyword);
//        offset
        $qb->setFirstResult($offset)
//            limit
            ->setMaxResults($limit);
//        getResult() recuperer une liste de resultat
//        getOneOrNull Result() recuperer le premier resultat
        return $qb->getQuery()->getResult();
    }

    private function _getQbWithSearch($keyword) {
        //        creer le constructeur de requete
        //        SELECT * FROM Client AS c
        //        WHERE deleted = 0 AND
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.deleted = 0');
        if ($keyword) {
            $qb->andWhere('c.nom LIKE :p1 OR c.prenom LIKE :p1 OR c.reference LIKE :p1');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }
    public function search(?string $ref = null, ?Client $refClient = null, ?\DateTime $startAt = null, ?\DateTime $endAt = null, mixed $state = null) {
        $qb = $this->createQueryBuilder("c");

        if ($ref != null) {
            $qb->where("c.reference = :ref");
            $qb->setParameter("ref", $ref);
        }
        if ($refClient != null) {
            $qb->andWhere("c.client = :client");
            $qb->setParameter("client", $refClient);
        }

        if ($startAt != null && $endAt != null) {
            $qb->andWhere("c.creationDate between :d and :c");
            $qb->setParameter("d" , $startAt);
            $qb->setParameter("c" , $endAt);
        }

        if($state != null){
            $qb->andWhere("c.etat = :d");
            $qb->setParameter("d", $state);
        }


        return $qb->getQuery()->getResult();
    }

    public function findWithClient($id) {
        //SELECT c.* FROM commande AS c
        $qb = $this->createQueryBuilder('c');
        //WHERE id = :p1
        $qb->where('c.id = :p1');
        $qb->setParameter('p1', $id);
        //LEFTJOIN client As cl ON cl.id = c.clientId
        $qb->leftJoin('c.client', 'cl');
        //ajoute cl.* dans la classe select
        $qb->addSelect('cl');

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findWithLinesAndProducts($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.id = :p1');
        $qb->setParameter('p1', $id);
        $qb->leftJoin('c.lignes', 'l');
        $qb->leftJoin('l.produit', 'p');
        $qb->addSelect('l');
        $qb->addSelect('p');

        return $qb->getQuery()->getOneOrNullResult();
    }


}
