<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function findByUser(User $customer): ?Cart
    {
        $query = $this->createQueryBuilder('c');
        $query->Where('c.customer = :customer')
            ->andWhere($query->expr()->eq('c.status', Cart::CART_OPEN))
            ->setParameter('customer', $customer);

        return $query->getQuery()
            ->getOneOrNullResult();
    }
}
