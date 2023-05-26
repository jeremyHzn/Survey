<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Values;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ValuesFixtures extends Fixture
{
    private ObjectManager $manager;
    private int $counter = 1;
    public const VALUE_REFERENCE_PREFIX = 'value-reference-';

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        [
            'parent_1' => $parent1ChildrenValues,
            'parent_2' => $parent2ChildrenValues,
            'parent_3' => $parent3ChildrenValues,
        ] = $this->dataProvider();

        $parent1 = $this->createValue('Notes');

        foreach ($parent1ChildrenValues as $parent1ChildValue) {
            $this->createValue($parent1ChildValue, $parent1);
        }

        $parent2 = $this->createValue('Choix');

        foreach ($parent2ChildrenValues as $parent2ChildValue) {
            $this->createValue($parent2ChildValue, $parent2);
        }

        $parent3 = $this->createValue('Textes');

        foreach ($parent3ChildrenValues as $parent3ChildValue) {
            $this->createValue($parent3ChildValue, $parent3);
        }

        $manager->flush();
    }

    private function createValue(string $name, ?Values $parent = null): Values
    {
        $value = new Values();

        $value->setValue($name);

        $value->setParent($parent);

        $this
            ->manager
            ->persist($value);

        $this->addReference(self::VALUE_REFERENCE_PREFIX.$this->counter, $value);

        $this->counter++;

        return $value;
    }

    private function dataProvider(): \Traversable|array
    {
        return [
            'parent_1' => [
                '1',
                '2',
                '3',
                '4',
                '5',
            ],
            'parent_2' => [
                'Oui',
                'Non',
                'Peut-être',
            ],
            'parent_3' => [
                'email',
                'text',
                'textarea',
                'password',
                'number',
                'date',
                'file',
                'hidden',
                'range',
                'tel',
            ],
        ];
    }
}
