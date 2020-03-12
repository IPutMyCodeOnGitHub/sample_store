<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $customer = new User();
            $customer->setEmail('user_' . $i . '@mail.com');
            $customer->setEmailCanonical('user_' . $i . '@mail.com');
            $customer->setEnabled(true);
            $customer->setUsername('user_' . $i . '@mail.com');
            $customer->setUsernameCanonical('user_' . $i . '@mail.com');
            $customer->setPlainPassword('123456');
            $customer->addRole(User::ROLE_DEFAULT);

            $manager->persist($customer);
            $this->addReference(User::class . '_' . $i, $customer);
            $manager->flush();
        }
    }
}
