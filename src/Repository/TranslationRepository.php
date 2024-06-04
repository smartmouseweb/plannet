<?php

namespace App\Repository;

use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Translation>
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

        public function findField($args): ?Translation
       {
           return $this->createQueryBuilder('t')
               ->andWhere('t.type = :type')
               ->andWhere('t.locale = :locale')
               ->andWhere('t.bindId = :bindId')
               ->andWhere('t.field = :field')
               ->setParameter('type', $args['type'])
               ->setParameter('locale', $args['locale'])
               ->setParameter('bindId', $args['bindId'])
               ->setParameter('field', $args['field'])
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

    //    /**
    //     * @return Translation[] Returns an array of Translation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Translation
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
