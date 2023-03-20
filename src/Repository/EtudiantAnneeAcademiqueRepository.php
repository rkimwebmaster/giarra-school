<?php

namespace App\Repository;

use App\Entity\EtudiantAnneeAcademique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtudiantAnneeAcademique>
 *
 * @method EtudiantAnneeAcademique|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtudiantAnneeAcademique|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtudiantAnneeAcademique[]    findAll()
 * @method EtudiantAnneeAcademique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantAnneeAcademiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtudiantAnneeAcademique::class);
    }

    public function save(EtudiantAnneeAcademique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EtudiantAnneeAcademique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EtudiantAnneeAcademique[] Returns an array of EtudiantAnneeAcademique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EtudiantAnneeAcademique
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
