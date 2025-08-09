<?php

namespace App\Repository;

use App\Entity\Snippet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Snippet>
 */
class SnippetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Snippet::class);
    }

    public function getSnippets(): array
    {
        $qb = $this->createQueryBuilder('snippet')
            ->leftJoin('snippet.comments', 'comments')->addSelect('comments')
            ->leftJoin('snippet.author', 'author')->addSelect('author')
            ->orderBy('snippet.id', 'DESC');
        
        return $qb->getQuery()->getResult();
    }

    public function getSnippet(int $id): Snippet
    {
        $qb = $this->createQueryBuilder('snippet')
            ->where("snippet.id = $id")
            ->leftJoin('snippet.comments', 'comments')->addSelect('comments')
            ->leftJoin('snippet.author', 'author')->addSelect('author')
            ->leftJoin('comments.author', 'comment_author')->addSelect('comment_author')
            ->orderBy('comments.id', 'DESC');

        return $qb->getQuery()->getSingleResult();
    }

    //    /**
    //     * @return Snippet[] Returns an array of Snippet objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Snippet
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
