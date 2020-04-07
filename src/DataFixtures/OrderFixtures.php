<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $order = new Order();

            /** @var User $customer */
            $customer = $this->getReference(User::class . '_' . $i);
            $order->setCustomer($customer);
            $order->setAddress("street_" . $i);
            $order->setPhoneNumber("+79996669966");
            $order->setCreatedAt(new \DateTime());
            $order->setStatus(0);

            $manager->persist($order);
            $this->addReference(Order::class . '_' . $i, $order);
            $manager->flush();
        }
    }
}
