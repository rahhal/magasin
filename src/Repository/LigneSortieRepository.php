<?php

namespace App\Repository;

use App\Entity\LigneSortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneSortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneSortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneSortie[]    findAll()
 * @method LigneSortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneSortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneSortie::class);
    }

    // /**
    //  * @return LigneSortie[] Returns an array of LigneSortie objects
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
    public function findOneBySomeField($value): ?LigneSortie
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLigneSortieBySortie($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.sortie', 's')
            ->andWhere('s.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }
    public function getByArticle($id)
    {
        return $this
            ->createQueryBuilder('l')
            ->andWhere('l.article IN (:id)')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getSumQte($idart,$id)
    {
        return $this
            ->createQueryBuilder('l')
            ->select('SUM(l.qte)')
            ->leftJoin('l.sortie', 's')
            ->leftJoin('l.article', 'a')
            ->where('s.id  IN (:id)')
            ->andWhere('a.id  = :idart')
            ->setParameter('idart', $idart)
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult()
            ->getSingleScalarResult();
        ;
    }
}
