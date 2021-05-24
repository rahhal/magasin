<?php

namespace App\Repository;

use App\Entity\Inventaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inventaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventaire[]    findAll()
 * @method Inventaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventaire::class);
    }

    // /**
    //  * @return Inventaire[] Returns an array of Inventaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inventaire
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLigneInventaireByInventaire($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.inventaire', 'i')
            ->andWhere('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function findInventaireByUser($id)
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function getByCurrentUser($id)
    {
        return $this->createQueryBuilder('i')
          ->innerJoin('i.user', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)

           ->andWhere('i.date = :date')
            ->setParameter('date', new \Datetime(date('Y-m-d')))

            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
