<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactMessage[]    findAll()
 * @method ContactMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }
    
    public function findGroupedByEmail()
    {
        return $this->createQueryBuilder('c')
            ->select('c.fromEmail', 'count(c.fromEmail) as total', 'c.createdAt', 'c.slug')
            // ->andWhere('c.email = :val')
            // ->setParameter('val', $value)
            // ->orderBy('c.id', 'ASC')
            // ->setMaxResults(10)
            ->groupBy('c.fromEmail')
            // ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
