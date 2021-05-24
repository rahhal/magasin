<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this-> paginator=$paginator;
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCategories($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.categorie','cat')
            ->andWhere('cat.designation = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(ArticleSearch $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('a')
//            ->select(['a','c','t','u'])
            ->select(['a','c','t'])

            ->leftJoin('a.categorie', 'c')
            ->leftJoin('a.type', 't')
           // ->leftJoin('a.user', 'u')

        ->andWhere('c.id = :categorie')  
        
        ->andWhere('t.id = :type') 
        
        // ->andWhere('u.id  = :user')
         ->setParameter('categorie', $search->categorie)
         ->setParameter('type', $search->type);
        // ->setParameter('user', $id);
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
    }

    private function getSearchQuery(ArticleSearch $search): QueryBuilder
    {
    }


    public function getArticles($categorie, $type)
    {
        return $this->createQueryBuilder('a')
            //->select('c','t','a')
            ->join('a.categorie', 'c')
            ->leftJoin('a.type', 't')

           // ->leftJoin('a.categorie','cat')
            ->where('c.id = :val')
            ->andWhere('t.id = :val1')
            ->setParameter('val', $categorie)
            ->setParameter('val1', $type)
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult()

            ;
    }
    public function getArticlesByCategorie($categorie)
    {
        return $this->createQueryBuilder('a')
            //->select('c','t','a')
            ->join('a.categorie', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $categorie)
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult()

            ;
    }
    public function getArticleByUser($id)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
          
            ->getResult();
    }
    public function findByCurrentUser($user)
    {
        return $this
            ->createQueryBuilder('a')
            ->andWhere('a.user = :user')
            ->setParameter('user', $user)
            ;
    }
}
