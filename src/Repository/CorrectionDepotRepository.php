<?php

namespace App\Repository;

use App\Entity\CorrectionDepot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CorrectionDepot>
 *
 * @method CorrectionDepot|null find($id, $lockMode = null, $lockVersion = null)
 * @method CorrectionDepot|null findOneBy(array $criteria, array $orderBy = null)
 * @method CorrectionDepot[]    findAll()
 * @method CorrectionDepot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorrectionDepotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorrectionDepot::class);
    }

    public function save(CorrectionDepot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CorrectionDepot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CorrectionDepot[] Returns an array of CorrectionDepot objects
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

//    public function findOneBySomeField($value): ?CorrectionDepot
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
