<?php

namespace App\Repository;

use App\Entity\NotificationSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationSettings[]    findAll()
 * @method NotificationSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationSettings::class);
    }

    // /**
    //  * @return NotificationSettings[] Returns an array of NotificationSettings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotificationSettings
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
