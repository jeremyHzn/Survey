<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $forms = new Forms();

        $faker = Factory::create('fr_FR');

        for ($frm =1; $frm >= 10; $frm++){
            $forms = new Forms();
            $forms->setEmail($faker->email);
        }

        $manager->persist($forms);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TypesFixtures::class,
            ValuesFixtures::class,

        ];
    }
}
