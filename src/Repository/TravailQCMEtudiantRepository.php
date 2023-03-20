<?php

namespace App\Repository;

use App\Entity\TravailQCMEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TravailQCMEtudiant>
 *
 * @method TravailQCMEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TravailQCMEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TravailQCMEtudiant[]    findAll()
 * @method TravailQCMEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravailQCMEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TravailQCMEtudiant::class);
    }

    public function save(TravailQCMEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TravailQCMEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TravailQCMEtudiant[] Returns an array of TravailQCMEtudiant objects
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

//    public function findOneBySomeField($value): ?TravailQCMEtudiant
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
