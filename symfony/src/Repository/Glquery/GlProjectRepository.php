<?php

namespace App\Repository\Glquery;

use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Entity\Glquery\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<GlProject>
 *
 * @method GlProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlProject[]    findAll()
 * @method GlProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlProjectRepository extends ServiceEntityRepository
{

    protected GetEntities $getEntitiesService;

    public function __construct(ManagerRegistry $registry, GetEntities $getEntities)
    {
        parent::__construct($registry, GlProject::class);
        $this->getEntitiesService = $getEntities;
    }

    public function add(GlProject $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GlProject $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getProjectsByUser(Request $request, array $users): array
    {
        $page = intval($request->get('page', 1));
        $limit = (int)$request->get('limit', -1);

        $where = $this->getEntitiesService->parseWhere($request->get('where', '{}'));
        $order = $this->getEntitiesService->prepareOrder($request->get('order'));

        $cQB = $this->getProjectsByUserQueryBuilder($users);
        $cQBCount = $this->getProjectsByUserQueryBuilder($users, false);

        if (!empty($where)) {
            $cQB = $this->getEntitiesService->where($cQB, $this->getEntitiesService->getAlias(GlProject::class), $where);
            $cQBCount = $this->getEntitiesService->where($cQB, $this->getEntitiesService->getAlias(GlProject::class), $where);
        }

        $count = $cQBCount->select($cQB->expr()->countDistinct('p'))->getQuery()->getSingleResult();

        if (is_int($limit) && $limit > 0) {
            $cQB->setFirstResult(GetEntities::prepareOffset($page, $limit));
            $cQB->setMaxResults($limit);
        }

        return [
            'items' => $cQB->getQuery()->getResult(),
            'count' => $count
        ];
    }

    protected function getProjectsByUserQueryBuilder(array $users, bool $groupBy = true) :QueryBuilder
    {
        $userNames = array_values(array_map(fn(User $u) => $u->getUsername(), $users));
        $userInstances = array_values(array_map(fn(User $u) => $u->getInstance(), $users));

        $cQB = $this->createQueryBuilder('p');
        $cQB->select('p')
            ->join(GlTimeNote::class, 'tn', Join::WITH, 'p.glId = tn.glProjectId AND p.glInstance = tn.glInstance')
            ->join(User::class, 'u', Join::WITH, 'tn.author = u.username AND tn.glInstance = u.instance')
            ->where($cQB->expr()->in('u.username', ':usernames'))
            ->andWhere($cQB->expr()->in('u.instance', ':instances'))
            ->setParameter('usernames', $userNames)
            ->setParameter('instances', $userInstances);

        if ($groupBy) {
            $cQB->groupBy('p');
        }

        return $cQB;
    }



//    /**
//     * @return GlProject[] Returns an array of GlProject objects
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

//    public function findOneBySomeField($value): ?GlProject
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
