<?php

namespace App\DataFixtures;

use App\Factory\ManufacturerFactory;
use App\Factory\ModelFactory;
use App\Factory\ProductFactory;
use App\Factory\TypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TypeFactory::createMany(10);
        ManufacturerFactory::createMany(10);

        ModelFactory::createMany(10, function() {
            return [
                'manufacturer' => ManufacturerFactory::random(),
                'type' => TypeFactory::random(),
            ];
        });

        ProductFactory::createMany(30, function (){
            return [
                'model' => ModelFactory::random(),
            ];
        });

        $manager->flush();
    }
}
