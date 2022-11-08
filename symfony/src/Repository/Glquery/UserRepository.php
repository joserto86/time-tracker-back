<?php

namespace App\Repository\Glquery;

use App\Entity\Glquery\User;
use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Repository\Main\AppUserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private AppUserRepository $appUserRepository;

    public function __construct(ManagerRegistry $registry, AppUserRepository $appUserRepository)
    {
        $this->appUserRepository = $appUserRepository;
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getGlUsersByUserName(string $userIdentifier): array
    {
        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->findOneBy(['username' => $userIdentifier]);
        $usernames = array_values(array_map(
            fn(AppUserInstance $au) => $au->getUsername(), $appUser->getAppUserInstances()->toArray()
        ));

        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.username IN (:usernames)')
            ->setParameter('usernames', $usernames)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
