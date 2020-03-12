<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\OrderItem;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class,
            ProductFixtures::class,
            OrderFixtures::class,
            OrderItemFixtures::class
        );
    }
}