<?php

namespace App\Repository;

use App\Entity\Entree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entree[]    findAll()
 * @method Entree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entree::class);
    }

    // /**
    //  * @return Entree[] Returns an array of Entree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entree
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function myFindOne($id)
    {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function findByArticle($id)
    {
        return $this
            ->createQueryBuilder('e')
            ->andWhere('e.ligneEntree IN (:id)')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function findByCurrentUser($user)
    {
        return $this
            ->createQueryBuilder('e')
            ->andWhere('e.user = :user')
            ->setParameter('user', $user)
            ;
    }
    public function getEntreeByUser($id)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }



    public function getEntreesByMonth($year, $month)
    {
        $date = new \DateTime("{$year}-{$month}-01");

        $qb = $this->createQueryBuilder('e');
        $query = $qb
            ->where('e.dateEntree BETWEEN :start AND :end')
            ->setParameter('start', $date->format('Y-m-d'))
            ->setParameter('end', $date->format('Y-m-t'))
        ;
        return $query->getQuery()->getResult();
    }
    public function findByDate($year)
    {
      //  $date = new \DateTime("{$year}-01-01");
        $qb = $this->createQueryBuilder('e');
        $query = $qb
            ->where('YEAR(e.dateEntree) = :year')
            ->setParameter('year', $year)
        ;
        return $query->getQuery()->getResult();
    }
}
