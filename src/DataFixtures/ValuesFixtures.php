<?php

namespace App\DataFixtures;

use App\Entity\Values;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ValuesFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager)
    {
        $parent = $this->createValue('Notes',$manager, null );
        $this->createValue('1', $manager, $parent);
        $this->createValue('2', $manager, $parent);
        $this->createValue('3', $manager, $parent);
        $this->createValue('4', $manager, $parent);
        $this->createValue('5', $manager, $parent);

        $parent = $this->createValue('Choix', $manager,null);
        $this->createValue('Oui', $manager, $parent);
        $this->createValue('Non', $manager, $parent);
        $this->createValue('Peut-être', $manager, $parent);

        $parent = $this->createValue('Textes', $manager,null);
        $this->createValue('email', $manager, $parent);
        $this->createValue('text', $manager, $parent);
        $this->createValue('textarea', $manager, $parent);
        $this->createValue('password', $manager, $parent);
        $this->createValue('number', $manager, $parent);
        $this->createValue('date', $manager, $parent);
        $this->createValue('file', $manager, $parent);
        $this->createValue('hidden', $manager, $parent);
        $this->createValue('range', $manager, $parent);
        $this->createValue('tel', $manager, $parent);

        $manager->flush();
    }

    private function createValue(string $name, ObjectManager $manager, Values $parent = null)
    {
        $value = new Values();
        $value->setValue($name);
        $value->setParent($parent);
        $manager->persist($value);

        $this->addReference('val-'.$this->counter, $value);
        $this->counter++;

        return $value;
    }
}