<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TypesFixtures
 */
final class TypesFixtures extends Fixture implements DataProviderInterface
{
    public const TYPE_REFERENCE_PREFIX = 'type-reference-';

    private ObjectManager $manager;

    /**
     * @param ObjectManager $manager
     * @return void
     * function load is public because it is used in the class Fixtures
     * set the manager to the manager
     * call the function loadTypes
     * flush the manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadTypes();

        $manager->flush();
    }

    /**
     * @return void
     * function loadTypes is private because it is only used in this class
     * foreach all types in dataProvider and create a new type with the value of the dataProvider
     * persist the type
     * add a reference to the type
     * if the key is less than the count of questions, add a reference to the type
     */
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

    /**
     * @return \Traversable|array
     * function dataProvider is private because it is only used in this class
     * return an array of types
     */
    private function dataProvider(): array
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
