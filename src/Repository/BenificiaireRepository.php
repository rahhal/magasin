<?php

namespace App\Repository;

use App\Entity\Benificiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Benificiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Benificiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Benificiaire[]    findAll()
 * @method Benificiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BenificiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Benificiaire::class);
    }

    // /**
    //  * @return Benificiaire[] Returns an array of Benificiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Benificiaire
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getBenificiaireByUser($id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function findByCurrentUser($user)
    {
        return $this
            ->createQueryBuilder('B')
            ->andWhere('B.user = :user')
            ->setParameter('user', $user)
            ;
    }
}
