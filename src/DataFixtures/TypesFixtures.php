<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class TypesFixtures extends Fixture
{
    public const TYPE_REFERENCE_PREFIX = 'type-reference-';

    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadTypes();

        $manager->flush();
    }

    private function loadTypes(): void
    {
        $types = $this->dataProvider();

        foreach ($types as $key => $value) {
            $type = new Types($value);

            $this
                ->manager
                ->persist($type);

            if ($key < QuestionsFixtures::COUNT_OF_QUESTIONS) {
                $this->addReference(self::TYPE_REFERENCE_PREFIX.$key, $type);
            }
        }
    }

    private function dataProvider(): \Traversable|array
    {
        return [
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
    }
}
