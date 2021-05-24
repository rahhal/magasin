<?php

namespace App\Repository;

use App\Entity\LigneEntree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneEntree|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneEntree|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneEntree[]    findAll()
 * @method LigneEntree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneEntreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneEntree::class);
    }

    // /**
    //  * @return LigneEntree[] Returns an array of LigneEntree objects
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
    public function findOneBySomeField($value): ?LigneEntree
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLigneEntreeByEntree($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.entree', 'e')
            ->andWhere('e.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }

    public function findLigneEntreeBySum($idart,$id)
    {
        return $this
            ->createQueryBuilder('l')
           ->select('SUM(l.qte_entr)')
            ->leftJoin('l.entree', 'e')
            ->leftJoin('l.article', 'a')
            ->where('e.id  IN (:id)')
            ->andWhere('a.id  = :idart')
            ->setParameter('idart', $idart)
            ->setParameter('id', $id)
            ->getQuery()
           // ->getOneOrNullResult()
            ->getSingleScalarResult();
        ;
    }
   /* public function findLigneEntreeBySum($id)
    {
        return $this->createQueryBuilder('l')
            // ->select('l.qte_entr')

             ->innerJoin('l.entree', 'e')
             ->where('e.id  IN (:id)')
           // ->innerJoin('l.article', 'a')
            //  ->select('l.qte_entr','a.libele')
           // ->andWhere('a.id  = :idart')
           // ->setParameter('idart', $idart)
            ->setParameter('id', $id)
            ->select('SUM(l.qte_entr)')
             ->groupBy('l.article')
            // ->orderBy('sum_qte', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }*/
    public function getByArticle($id)
    {
        return $this
            ->createQueryBuilder('l')
            ->andWhere('l.article IN (:id)')
            ->setParameter('id', $id)
           // ->orderBy('l.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function getLigneEntreeByUser($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
