<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CartItemFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            /** @var Product $product */
            $product = $this->getReference(Product::class . '_' . $i);
            $price = $product->getPrice();

            /** @var Cart $cart */
            $cart = $this->getReference(Cart::class . '_' . $i);

            $cartItem = new CartItem($cart, $product, $price, 1);
            $manager->persist($cartItem);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProductFixtures::class,
            CartFixtures::class,
        );
    }
}
