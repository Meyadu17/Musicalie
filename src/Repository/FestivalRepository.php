<?php

namespace App\Repository;

use App\Entity\Festival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Festival>
 *
 * @method Festival|null find($id, $lockMode = null, $lockVersion = null)
 * @method Festival|null findOneBy(array $criteria, array $orderBy = null)
 * @method Festival[]    findAll()
 * @method Festival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    /**
     * @return Festival[] Returns an array of Festival objects
     */
    public function findLastFestival(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM main f ORDER BY f.id  DESC';

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    public function findOneBySomeField($value): ?Festival
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
