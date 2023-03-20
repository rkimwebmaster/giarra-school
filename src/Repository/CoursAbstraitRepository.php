<?php

namespace App\Repository;

use App\Entity\CoursAbstrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoursAbstrait>
 *
 * @method CoursAbstrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursAbstrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursAbstrait[]    findAll()
 * @method CoursAbstrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursAbstraitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursAbstrait::class);
    }

    public function save(CoursAbstrait $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CoursAbstrait $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CoursAbstrait[] Returns an array of CoursAbstrait objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CoursAbstrait
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
