<?php

namespace App\Repository;

use App\Entity\FraisAbstrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisAbstrait>
 *
 * @method FraisAbstrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisAbstrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisAbstrait[]    findAll()
 * @method FraisAbstrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisAbstraitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisAbstrait::class);
    }

    public function save(FraisAbstrait $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FraisAbstrait $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FraisAbstrait[] Returns an array of FraisAbstrait objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FraisAbstrait
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
