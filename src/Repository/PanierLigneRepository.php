<?php

namespace App\Repository;

use App\Entity\PanierLigne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PanierLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method PanierLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method PanierLigne[]    findAll()
 * @method PanierLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierLigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PanierLigne::class);
    }

    // /**
    //  * @return PanierLigne[] Returns an array of PanierLigne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PanierLigne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
