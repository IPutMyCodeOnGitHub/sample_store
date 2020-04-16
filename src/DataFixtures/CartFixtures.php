<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CartFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            /** @var User $customer */
            $customer = $this->getReference(User::class . '_' . $i);

            $cart = new Cart($customer);
            $cart->setStatus(CART::CART_OPEN);

            $manager->persist($cart);
            $this->addReference(Cart::class . '_' . $i, $cart);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CustomerFixtures::class,
        );
    }
}
