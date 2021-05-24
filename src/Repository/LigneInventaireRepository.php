<?php

namespace App\Repository;

use App\Entity\LigneInventaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneInventaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneInventaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneInventaire[]    findAll()
 * @method LigneInventaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneInventaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneInventaire::class);
    }

    // /**
    //  * @return LigneInventaire[] Returns an array of LigneInventaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneInventaire
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
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
    public function getInventaire($id): ?LigneInventaire
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.invenaire','inv')
            ->andWhere('inv.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function myLigneInventaire($id)
    { return $this-> createQueryBuilder('l')
        ->leftJoin('l.inventaire','inv')
        ->where('inv.id = :id')
        //->andWhere('n.user = :user')
        ->andWhere('inv.date= :date')
        ->setParameter('date', new \Datetime(date('d-m-Y')))
        ->setParameter('id', $id)
        //->andWhere('inv.id= :id')
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
    public function findByArticle($id)
    {
        return $this
            ->createQueryBuilder('l')
            ->andWhere('l.article IN (:id)')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

}
