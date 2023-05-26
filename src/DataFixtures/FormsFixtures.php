<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormsFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     * function load is public because it is used in the class Fixtures
     * create a new form
     * set the email of the form
     * persist the form
     * flush the manager
     */
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

    /**
     * @return string[]
     * function getDependencies is public because it is used in the class Fixtures
     * return an array of the classes that this class depends on
     */
    public function getDependencies()
    {
        return [
            TypesFixtures::class,
            ValuesFixtures::class,
        ];
    }
}
