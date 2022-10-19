<?php

namespace App\Repository;

use App\Entity\BookByTazesId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookByTazesId>
 *
 * @method BookByTazesId|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookByTazesId|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookByTazesId[]    findAll()
 * @method BookByTazesId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookByTazesIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookByTazesId::class);
    }

    public function save(BookByTazesId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BookByTazesId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BookByTazesId[] Returns an array of BookByTazesId objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BookByTazesId
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
