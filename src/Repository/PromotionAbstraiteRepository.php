<?php

namespace App\Repository;

use App\Entity\PromotionAbstraite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromotionAbstraite>
 *
 * @method PromotionAbstraite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromotionAbstraite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromotionAbstraite[]    findAll()
 * @method PromotionAbstraite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionAbstraiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromotionAbstraite::class);
    }

    public function save(PromotionAbstraite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PromotionAbstraite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PromotionAbstraite[] Returns an array of PromotionAbstraite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PromotionAbstraite
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
