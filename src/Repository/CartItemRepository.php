<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartItem[]    findAll()
 * @method CartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function findCartItem(Cart $cart, Product $product): ?CartItem
    {
        $query = $this->createQueryBuilder('c');
        $query->andWhere('c.cart = :cart')
            ->andWhere('c.product = :product')
            ->setParameter('cart', $cart)
            ->setParameter('product', $product);

        return $query->getQuery()
            ->getOneOrNullResult();
    }
}
