<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
	
	private ObjectManager $entityManager;
	
    public function __construct(ManagerRegistry $registry)
    {
		$this->entityManager = $registry->getManager();
        parent::__construct($registry, Currency::class);
    }
	
    public function save(Currency $currency): void {
        $this->entityManager->persist($currency);
        $this->entityManager->flush();
    }

    // /**
    //  * @return Currency[] Returns an array of Currency objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Currency
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	
	public function findOneByCode(string $currencyCode): ?Currency {

		$result = $this->findByCode($currencyCode);

		if (array_key_exists(0, $result)) {
			return $result[0];
		}
		
		return null;
	}

}
