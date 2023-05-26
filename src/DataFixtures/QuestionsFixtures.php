<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Questions;
use App\Entity\Types;
use App\Entity\Values;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use LogicException;

final class QuestionsFixtures extends Fixture implements DependentFixtureInterface
{
    public const COUNT_OF_QUESTIONS = 4;

    private ObjectManager $manager;

    public function getDependencies(): \Traversable|array
    {
        return [
            TypesFixtures::class,
            ValuesFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadQuestions();

        $manager->flush();
    }

    public function loadQuestions(): void
    {
        $parent = null;

        $subjects = $this->dataProvider();

        foreach ($subjects as $key => $subject) {
            $typeReferenceKey = TypesFixtures::TYPE_REFERENCE_PREFIX . $key;

            $valueReferenceKey = ValuesFixtures::VALUES_REFERENCE_PREFIX . $key;

            if ($key === 0) {
                $parent = $this->createQuestion(
                    subject: $subject,
                    typeReferenceKey: $typeReferenceKey,
                    valueReferenceKey: $valueReferenceKey
                );

                continue;
            }

            $this->createQuestion(
                subject: $subject,
                parent: $parent,
                typeReferenceKey: $typeReferenceKey,
                valueReferenceKey: $valueReferenceKey
            );
        }
    }

    public function createQuestion(
        string $subject,
        ?Questions $parent = null,
        ?string $typeReferenceKey = null,
        ?string $valueReferenceKey = null
    ): Questions {
        [
            'type' => $type,
            'value' => $value,
        ] = $this->getTypesAndValuesInstancesOrThrowException(
            $typeReferenceKey,
            $valueReferenceKey
        );

        $question = new Questions($type, $value);

        $question
            ->setCategory('YOU HAVE TO CHECK THIS BRO')
            ->setSubject($subject)
            ->setParent($parent);

        $this
            ->manager
            ->persist($question);

        return $question;
    }

    private function dataProvider(): \Traversable|array
    {
        return [
            'SAV',
            'La personne que vous avez eu au téléphone était-elle audible ?',
            'La personne que vous avez eu au téléphone était-elle aimable ?',
            'La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?',
        ];
    }

    private function getTypesAndValuesInstancesOrThrowException(
        string $typeReferenceKey,
        string $valueReferenceKey
    ): \Traversable|array {
        $type = $this->getReference($typeReferenceKey);

        $value = $this->getReference($valueReferenceKey);

        if (
            $type instanceof Types === false
            ||
            $value instanceof Values === false
        ) {
            throw new LogicException('You have a problem on references.');
        }

        return [
            'type' => $type,
            'value' => $value,
        ];
    }
}
