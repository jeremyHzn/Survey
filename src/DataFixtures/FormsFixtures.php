<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class FormsFixtures
 */
class FormsFixtures extends Fixture implements DependentFixtureInterface
{

    private $faker;

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadForm();
        $manager->flush();
    }
    public function loadForm() :void
    {
        // get all emails
        $email = $this->dataProvider();
        $this->createForm(
            email: $email;
        )
    }
    public function createForm(string $email) :Forms
    {
        $form = new Forms();
        $email = $form->setEmail($email);
        return $email;
    }
    public function dataProvider() :array
    {
        return [
            "user.mail@gmail.com"
        ];
    }


}
