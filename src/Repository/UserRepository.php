<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

	private ObjectManager $entityManager;
	
    public function __construct(ManagerRegistry $registry)
    {
		$this->entityManager = $registry->getManager();
        parent::__construct($registry, User::class);
    }
	

    public function save(User $user): void {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
	
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	
	public function getUsersSubscribingCurrencyChanges(Currency $currency) : array {
        return $this->createQueryBuilder('user')
                ->andWhere('user.active = :isActive')
                ->setParameter('isActive', true)
		        ->join('user.notificationsSettngs', 'ns')		
                ->andWhere('ns.currency = :currencyObject')
                ->setParameter('currencyObject', $currency)
                ->orderBy('user.id', 'DESC')
                ->getQuery()
				->getResult();
	}
	
	public function findOneByEmail(string $email): ?User {
		$result = $this->findByEmail($email);

		if (array_key_exists(0, $result)) {
			return $result[0];
		}
		
		return null;
	}
}
