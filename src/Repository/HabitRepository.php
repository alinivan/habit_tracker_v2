<?php

namespace App\Repository;

use App\Entity\Habit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habit>
 *
 * @method Habit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habit[]    findAll()
 * @method Habit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habit::class);
    }

    /**
     * @return Habit[] Returns an array of active Habit objects for a specific category
     */
    public function findActiveByCategory(int $categoryId): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.category = :categoryId')
            ->andWhere('h.active = :active')
            ->setParameter('categoryId', $categoryId)
            ->setParameter('active', true)
            ->orderBy('h.order', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Habit[] Returns an array of Habit objects for a specific user
     */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findOneByNameAndUser(string $name, int $userId): ?Habit
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.name = :name')
            ->andWhere('h.user = :userId')
            ->setParameter('name', $name)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Habit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Habit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
} 