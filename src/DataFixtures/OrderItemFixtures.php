<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            /** @var Product $product */
            $product = $this->getReference(Product::class . '_' . $i);
            $price = $product->getPrice();

            /** @var Order $order */
            $order = $this->getReference(Order::class . '_' . $i);

            $orderItem = new OrderItem($order, $product, $price, 1);

            $manager->persist($orderItem);
            $manager->flush();
        }
    }
}
