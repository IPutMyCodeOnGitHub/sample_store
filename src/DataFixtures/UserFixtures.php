<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@seller.com');
        $admin->setEmailCanonical('admin@seller.com');
        $admin->setEnabled(true);
        $admin->setUsername('admin@seller.com');
        $admin->setUsernameCanonical('admin@seller.com');
        $admin->setPlainPassword('12345');
        $admin->addRole('ROLE_ADMIN');

        $manager->persist($admin);
        $this->addReference(User::class . '_000', $admin);
        $manager->flush();
    }
}
