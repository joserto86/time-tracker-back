<?php

namespace App\Repository\Glquery;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Entity\Glquery\User;
use App\Model\GlMilestone;
use App\Serializer\TimeTrackerModelNormalizer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Irontec\SymfonyTools\GetEntities\GetEntities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<GlIssue>
 *
 * @method GlIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlIssue[]    findAll()
 * @method GlIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlIssueRepository extends ServiceEntityRepository
{
    private const AVAILABLE_METHODS = [
        GetEntities::METHOD_EQUAL_SIGN,
        GetEntities::METHOD_LIKE,
        GetEntities::METHOD_NOT_LIKE,
        GetEntities::METHOD_NOT_EQUAL_SIGN,
        GetEntities::METHOD_GREATER_THAN_SIGN,
        GetEntities::METHOD_GREATER_THAN_EQUAL_SIGN,
        GetEntities::METHOD_LESSER_THAN_SIGN,
        GetEntities::METHOD_LESSER_THAN_EQUAL_SIGN
    ];

    protected GetEntities $getEntitiesService;

    public function __construct(ManagerRegistry $registry, GetEntities $getEntities)
    {
        parent::__construct($registry, GlIssue::class);
        $this->getEntitiesService = $getEntities;
    }

    public function add(GlIssue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GlIssue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMilestonesByProject(Request $request, GlProject $project): array
    {
        $page = intval($request->get('page', 1));
        $limit = (int)$request->get('limit', 10);

        $where = $this->getEntitiesService->parseWhere($request->get('where', '{}'));
        $order = $this->getEntitiesService->prepareOrder($request->get('order'), null);

        $cQB = $this->getMilestonesByProjectQueryBuilder($project, $where, $order);
        $cQBCount = $this->getMilestonesByProjectQueryBuilder($project, $where);

        $count = $cQBCount->select($cQB->expr()->countDistinct("JSON_EXTRACT(i.data, '$.milestone')"))->getQuery()->getSingleResult();

        if (is_int($limit) && $limit > 0) {
            $cQB->setFirstResult(GetEntities::prepareOffset($page, $limit));
            $cQB->setMaxResults($limit);
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new TimeTrackerModelNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $results = $cQB->getQuery()->getResult();
        $data = [];

        foreach ($results as $result) {
            foreach ($result as $key => $item) {
                $item = json_encode(json_decode($item, true));
                $data[] = $serializer->deserialize($item, GlMilestone::class, JsonEncoder::FORMAT);
            }
        }

        return [
            'items' => $data,
            'count' => $count
        ];
    }

    protected function getMilestonesByProjectQueryBuilder(GlProject $project, array $where = null, array $order = null) :QueryBuilder
    {
        $cQB = $this->createQueryBuilder('i')
            ->select("DISTINCT(JSON_EXTRACT(i.data, '$.milestone')) AS milestone")
            ->where("JSON_EXTRACT(i.data, '$.milestone.id') IS NOT NULL")
            ->andWhere('i.glProjectId = :glProjectId')
            ->setParameter('glProjectId', $project->getGlId());

        if ($where) {
            foreach ($where as $key => $value) {
                if (in_array($value[GetEntities::PARAM_METHOD], self::AVAILABLE_METHODS) ) {
                    $expr = "JSON_EXTRACT(i.data, '$.milestone.{$value[GetEntities::PARAM_FIELD]}') {$value[GetEntities::PARAM_METHOD]} '{$value[GetEntities::PARAM_VALUE]}'";
                    $cQB->andWhere($expr);
                }
            }
        }

        if ($order) {
            foreach ($order as $key => $value) {
                $cQB->addOrderBy("JSON_EXTRACT(i.data, '$.milestone.{$value[GetEntities::PARAM_FIELD]}')", $value[GetEntities::PARAM_ORDER]);
            }
        }

        return $cQB;
    }

//    /**
//     * @return GlIssue[] Returns an array of GlIssue objects
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

//    public function findOneBySomeField($value): ?GlIssue
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
