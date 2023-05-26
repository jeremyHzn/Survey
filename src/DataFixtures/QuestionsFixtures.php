<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Questions;
use App\Entity\Types;
use App\Entity\Values;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class QuestionsFixtures extends Fixture implements DependentFixtureInterface
{
    public const COUNT_OF_QUESTIONS = 4;

    private ObjectManager $manager;

    public function getDependencies(): iterable
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
            $typeReferenceKey = TypesFixtures::TYPE_REFERENCE_PREFIX.$key;

            $valueReferenceKey = ValuesFixtures::VALUE_REFERENCE_PREFIX.$key;

            if (0 === $key) {
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

    private function dataProvider(): iterable
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
    ): iterable {
        $type = $this->getReference($typeReferenceKey);

        $value = $this->getReference($valueReferenceKey);

        if (
            false === $type instanceof Types
            ||
            false === $value instanceof Values
        ) {
            throw new \LogicException('You have a problem on references.');
        }

        return [
            'type' => $type,
            'value' => $value,
        ];
    }
}
