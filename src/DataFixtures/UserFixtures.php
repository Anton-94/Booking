<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail(sprintf('demo%d@mail.com', $i));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
