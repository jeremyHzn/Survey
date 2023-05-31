<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TypesFixtures.
 */
final class TypesFixtures extends Fixture implements DataProviderInterface
{
    public const TYPE_REFERENCE_PREFIX = 'type-reference-';

    private ObjectManager $manager;

    /**
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadTypes();

        $manager->flush();
    }

    /**
     * @return void
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
     */
    public function dataProvider(): array
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
