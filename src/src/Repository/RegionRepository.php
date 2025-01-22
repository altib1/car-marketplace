<?php

namespace App\Repository;

use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    public function findByCountry($countryId)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.country = :countryId')
            ->setParameter('countryId', $countryId)
            ->orderBy('r.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Add custom methods for querying the Region entity here
}