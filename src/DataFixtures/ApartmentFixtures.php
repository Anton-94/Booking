<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApartmentFixtures extends Fixture
{
    private const APARTMENTS = [
         [
             'name' => 'Radisson',
             'price' => 300
         ],
         [
             'name' => 'Qubus hotel',
             'price' => 200
         ],
         [
             'name' => 'Hotel Number One',
             'price' => 100
         ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::APARTMENTS as $apartmentData) {
            $apartment = new Apartment();
            $apartment->setName($apartmentData['name']);
            $apartment->setSlots(rand(2, 4));
            $apartment->setPrice($apartmentData['price']);
            $manager->persist($apartment);
        }

        $manager->flush();
    }
}