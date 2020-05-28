<?php

namespace App\Repository;

use App\Entity\Firm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Firm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Firm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Firm[]    findAll()
 * @method Firm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FirmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Firm::class);
    }

    public function getQuery()
    {
        return $this->createQueryBuilder('f')->getQuery();
    }
}
