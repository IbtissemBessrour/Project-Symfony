<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nomEvenement LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%')
            ->getQuery()
            ->getResult();
    }

    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.typeEvenement = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    public function findAfterDate(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.dateEvenement >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    public function findBySort(string $sort, string $order = 'ASC'): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.' . $sort, $order)
            ->getQuery()
            ->getResult();
    }
}