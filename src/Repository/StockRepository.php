<?php

namespace App\Repository;

use App\Entity\Stock;
use App\Entity\StockSearch;
use App\Entity\StockSearchArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Stock::class);
        $this-> paginator=$paginator;
    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stock
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByCurrentDate()
    {
        return $this
            ->createQueryBuilder('s')
            ->andWhere('s.date = :date')
            ->setParameter('date', new \Datetime(date('d-m-Y')))
            ;
    }
    /* public function findByArticle($value)
    {
        return $this
            ->createQueryBuilder('s')
            ->andWhere('s.article = :val')
            ->setParameter('val', $value)
            ;
    } */
    public function findByArticle($id)
    {
        return $this
            ->createQueryBuilder('s')
            ->andWhere('s.article IN (:id)')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(StockSearch $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('s')
            ->select('a','s')
            ->join('s.article', 'a');


        if (!empty($search->categorie)) {
            $query = $query
                ->andWhere('a.categorie = :val')
                ->setParameter('val', $search->categorie)
            ;
        }
        if (!empty($search->type)) {
            $query = $query
                ->andWhere('a.type = :val1')
                ->setParameter('val1', $search->type);

        }
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
        /*$query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );*/
    }

    private function getSearchQuery(StockSearch $search): QueryBuilder
    {
    }


    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearchArticle(StockSearchArticle $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('s')
            ->select('a','s')
            ->join('s.article', 'a');


        if (!empty($search->article)) {
            $query = $query
//                ->andWhere('a.article = :val')
                ->andWhere('a.article IN (:article)')
                ->setParameter('val', $search->article)
            ;
        }
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
        /*$query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );*/
    }

    private function getSearchArticleQuery(StockSearchArticle $search): QueryBuilder
    {
    }


    public function getStockByUser($id)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
