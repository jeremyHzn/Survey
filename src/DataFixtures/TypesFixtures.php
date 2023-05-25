<?php

namespace App\DataFixtures;

use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypesFixtures extends Fixture
{

    public const TYPE_REFERENCE_PREFIX = 'type-reference-';
    public function load(ObjectManager $manager)
    {


        $this->loadTypes($manager);
        $manager->flush();
    }

    private function loadTypes(ObjectManager $manager)
    {
        $types = [
            'text',
            'textarea',
            'radio',
            'checkbox',
            'select',
            'email',
            'number',
            'date',
            'file',
            'hidden',
            'password',
            'range',
            'reset',
            'search',
            'submit',
            'tel',
            'url',
            'color',
            'datetime-local',
            'month',
            'time',
            'week',
        ];

        foreach ($types as $key => $value) {
            $type = new Types($value);
            $manager->persist($type);
            if ($key < QuestionsFixtures::COUNT_OF_QUESTIONS) {
                $this->addReference(self::TYPE_REFERENCE_PREFIX.$key, $type);
            }
        }
    }
}