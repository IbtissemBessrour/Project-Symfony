<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

         /**
     * Summary of getTotalNombrePlaces
     * New
     */
    public function getTotalNombreSession(): int
    {
        return $this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * Summary of getTotalNombrePlaces
     * End New
     */
     /**
     * Summary of getTotalNombrePlaces
     * New
     */
    // Méthode pour compter les sessions d'aujourd'hui
    public function countSessionsToday(): int
    {
        // Calculer le nombre de sessions créées aujourd'hui
        $today = new \DateTime('today');
        
        return (int) $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.dateDebue >= :today') // ou dateDebue si c'est la date de début
            ->setParameter('today', $today)
            ->getQuery()
            ->getSingleScalarResult();  // Retourner un entier
    }
    /**
     * Summary of getTotalNombrePlaces
     * End New
     */

}
