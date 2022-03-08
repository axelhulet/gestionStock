<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countBySearch($keyword) {

        $qb = $this->_getQbWithSearch($keyword);
        $qb->select('count(p.id)');
//        permet de récupérer une valeur unique et non un objet ou une collection
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
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.deleted = 0');
        if ($keyword) {
            $qb->andWhere('p.nom LIKE :p1  OR p.reference LIKE :p1');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }
    public function countByRef($ref)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.reference LIKE :p1');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(p.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}
