<?php

namespace App\Repository;

use App\Entity\Habit;
use App\Entity\Tracker;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tracker>
 *
 * @method Tracker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tracker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tracker[]    findAll()
 * @method Tracker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tracker::class);
    }

    //    /**
    //     * @return Tracker[] Returns an array of Tracker objects
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

    //    public function findOneBySomeField($value): ?Tracker
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByDateRange(Habit $habit, User $user, \DateTime $startDate, \DateTime $endDate): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.habit = :habit')
            ->andWhere('t.user = :user')
            ->andWhere('t.date BETWEEN :start_date AND :end_date')
            ->setParameter('habit', $habit)
            ->setParameter('user', $user)
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate)
            ->orderBy('t.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getSumOfTodayProductiveMinutes(User $user): float
    {
        $today = new \DateTime('today');
        
        $result = $this->createQueryBuilder('t')
            ->select('SUM(t.value)')
            ->join('t.habit', 'h')
            ->andWhere('t.user = :user')
            ->andWhere('t.date = :date')
            ->andWhere('h.isProductive = true')
            ->andWhere('h.measurement = :measurement')
            ->setParameter('user', $user)
            ->setParameter('date', $today)
            ->setParameter('measurement', 'min')
            ->getQuery()
            ->getSingleScalarResult();
            
        return $result ?? 0;
    }

    public function getTodayStartHour(User $user): ?string
    {
        $today = new \DateTime('today');
        
        $result = $this->createQueryBuilder('t')
            ->select('MIN(t.createdAt)')
            ->andWhere('t.user = :user')
            ->andWhere('t.date = :date')
            ->setParameter('user', $user)
            ->setParameter('date', $today)
            ->getQuery()
            ->getSingleScalarResult();
            
        return $result ? (new \DateTime($result))->format('H:i') : null;
    }

    public function getSumOfPointsLast7Days(User $user): float
    {
        $endDate = new \DateTime('today');
        $startDate = (new \DateTime('today'))->modify('-6 days');
        
        $result = $this->createQueryBuilder('t')
            ->select('SUM(t.points)')
            ->andWhere('t.user = :user')
            ->andWhere('t.date BETWEEN :start_date AND :end_date')
            ->setParameter('user', $user)
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate)
            ->getQuery()
            ->getSingleScalarResult();
            
        return $result ?? 0;
    }

    public function getLastValueForHabit(Habit $habit): ?float
    {
        $result = $this->createQueryBuilder('t')
            ->select('t.value')
            ->andWhere('t.habit = :habit')
            ->setParameter('habit', $habit)
            ->orderBy('t.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
            
        return $result ? $result['value'] : null;
    }
}
