<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }


    public function findBestSeries($page)
    {
        // en DQL

       /* $entityManager= $this->getEntityManager(); // on ne peut pas passer le entity manager en aparametre de la methode car on est pas dans un controller
        $dql = "select  s from  App\Entity\Serie as s where s.vote > 8 and  s.popularity >100 order by s.popularity DESC ";
        $query = $entityManager->createQuery($dql);
        $query->setMaxResults(50);
        $results = $query->getResult();
        return $results; */

        // avec queryBuilder

        $queryBuilder = $this->createQueryBuilder('s');
       // $queryBuilder->andWhere('s.vote >8') -> andWhere('s.popularity>100')->orderBy('s.popularity','DESC');
        $query = $queryBuilder->getQuery();
        $queryBuilder->leftJoin("s.seasons", "seasons"); // jointure manuelle, leftjoin ajoute les series sans saison
        $queryBuilder->addSelect('seasons'); // reduire encore plus le nbre de query

        $offset = ($page -1) *10;
        $query->setFirstResult($offset);
       $query->setMaxResults(10);

       $paginator = new Paginator($query);
        //return $query->getResult();
        return $paginator;


    }

    // /**
    //  * @return Serie[] Returns an array of Serie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Serie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
