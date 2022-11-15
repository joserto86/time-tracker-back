<?php

namespace App\Repository\Glquery;

use App\Entity\Glquery\ViewGlTimeNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ViewGlTimeNote>
 *
 * @method ViewGlTimeNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewGlTimeNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewGlTimeNote[]    findAll()
 * @method ViewGlTimeNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewGlTimeNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewGlTimeNote::class);
    }

    public function add(ViewGlTimeNote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ViewGlTimeNote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    protected function getTimeNotesByFilters()
//    {
//        $cQB = $this->createQueryBuilder('tn');
//        $cQB->select('tn')
//            ->where()
//    }

//    /**
//     * @return GlTimeNote[] Returns an array of GlTimeNote objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GlTimeNote
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
