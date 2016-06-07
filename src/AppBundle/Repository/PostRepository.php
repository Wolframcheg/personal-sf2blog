<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByTag($tagName){
        return $this->createQueryBuilder('post')
            ->select('post, tag')
            ->leftJoin('post.tags', 'tag')
            ->where('tag.name = :name')
            ->andWhere('post.isPublish = :isPublish')
            ->setParameter('name', $tagName)
            ->setParameter('isPublish', 1)
            ->orderBy('post.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByWord($word){
        return $this->createQueryBuilder('post')
            ->select('post, tag')
            ->leftJoin('post.tags', 'tag')
            ->andWhere('post.isPublish = :isPublish')
            ->andWhere('post.title LIKE :word OR post.content LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->setParameter('isPublish', 1)
            ->orderBy('post.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function forSitemap()
    {
        return $this->createQueryBuilder('post')
            ->select('post')
            ->where('post.isPublish = :isPublish')
            ->setParameter('isPublish', 1)
            ->orderBy('post.publishedAt', 'DESC')
            ->getQuery()
            ->useResultCache(true, 600, 'sitemap_cache_id')
            ->getResult()
            ;
    }
}
