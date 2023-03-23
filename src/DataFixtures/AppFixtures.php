<?php

namespace App\DataFixtures;

use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProductFactory::createMany(50);
        $manager->flush();
    }
}