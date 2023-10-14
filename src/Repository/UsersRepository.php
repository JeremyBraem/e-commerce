<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

//    /**
//     * @return Users[] Returns an array of Users objects
//     */
        public function findByAge($ageMin, $ageMax)
        {
            $qb = $this->createQueryBuilder('u');
            $this->addAge($qb, $ageMin, $ageMax);
            return $qb->getQuery()->getResult();
            ;
        }
        
        public function statPersonne($ageMin, $ageMax)
        {
            $qb = $this->createQueryBuilder('u')
                ->select('avg(u.age) as ageMoyen, count(u.id) as nbrPersonne');

            $this->addAge($qb, $ageMin, $ageMax);

            $qb->getQuery();
            return $qb->getQuery()->getScalarResult();
            ;
        }

        private function addAge(ORMQueryBuilder $qb, $ageMin, $ageMax)
        {
            $qb->andWhere('u.age >= :ageMin and u.age <= :ageMax')
            ->setParameters(['ageMin' => $ageMin, 'ageMax' => $ageMax])
            ;
        }
}   
