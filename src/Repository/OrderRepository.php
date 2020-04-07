<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findLastOrder(User $customer): ?Order
    {
        $query = $this->createQueryBuilder('o');
        $query->where('o.customer = :customer')
            ->andWhere($query->expr()->eq('o.status', Order::ORDER_OPEN))
            ->setParameter('customer', $customer)
            ->orderBy('o.createdAt', 'desc')
            ->getFirstResult();

        return $query->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByPhoneNumber($number): ?Order
    {
        $query = $this->createQueryBuilder('o');
        $query->Where('o.phoneNumber = :number')
            ->setParameter('number', $number);

        return $query->getQuery()
            ->getOneOrNullResult();
    }
}
