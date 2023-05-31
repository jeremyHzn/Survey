<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Questions;
use App\Entity\Types;
use App\Entity\Values;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


/**
 * Class QuestionsFixtures.
 */
final class QuestionsFixtures extends Fixture implements DependentFixtureInterface, DataProviderInterface
{
    public const COUNT_OF_QUESTIONS = 4;
    public const QUESTION_REFERENCE_PREFIX = "question-reference-";
    private ObjectManager $manager;

    /**
     * @return iterable
     */
    public function getDependencies(): iterable
    {
        return [
            TypesFixtures::class,
            ValuesFixtures::class,
        ];
    }

    /**
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadQuestions();

        $manager->flush();
    }

    /**
     * @return void
     */
    public function loadQuestions(): void
    {
        $parent = null;
        $subjects = $this->dataProvider();

        foreach ($subjects as $key => $subject) {
            $typeReferenceKey = TypesFixtures::TYPE_REFERENCE_PREFIX.$key;
            $valueReferenceKey = ValuesFixtures::VALUE_REFERENCE_PREFIX.$key;
            $questionReferenceKey = self::QUESTION_REFERENCE_PREFIX.$key;

            if (0 === $key) {
                $parent = $this->createQuestion(
                    subject: $subject,
                    typeReferenceKey: $typeReferenceKey,
                    valueReferenceKey: $valueReferenceKey,
                    questionReferenceKey: $questionReferenceKey
                );
                continue;
            }
            $this->createQuestion(
                subject: $subject,
                parent: $parent,
                typeReferenceKey: $typeReferenceKey,
                valueReferenceKey: $valueReferenceKey,
                questionReferenceKey: $questionReferenceKey,
            );
        }
    }

    /**
     * @return Questions
     */
    public function createQuestion(string $subject, ?Questions $parent = null, ?string $typeReferenceKey = null, ?string $valueReferenceKey = null, ?string $questionReferenceKey = null): Questions
    {
        [
            'type' => $type,
            'value' => $value,
        ] = $this->helperGetTypesAndValuesReferencesKey(
            $typeReferenceKey,
            $valueReferenceKey
        );

        $question = new Questions($type, $value);

        $question
            ->setSubject($subject)
            ->setParent($parent);

        $this
            ->manager
            ->persist($question);

        if (null !== $questionReferenceKey) {
            $this->addReference($questionReferenceKey, $question);
        }

        return $question;
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'SAV', // parent
            'La personne que vous avez eu au téléphone était-elle audible ?',
            'La personne que vous avez eu au téléphone était-elle aimable ?',
            'La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?',
        ];
    }

    /**
     * @throws \LogicException
     */
    private function helperGetTypesAndValuesReferencesKey(string $typeReferenceKey, string $valueReferenceKey): iterable
    {
        $type = $this->getReference($typeReferenceKey);
        $value = $this->getReference($valueReferenceKey);

        if (
            false === $type instanceof Types
            ||
            false === $value instanceof Values
        ) {
            throw new \LogicException('helperGetTypesAndValuesReferencesKey : Reference key of Types or Values not found.');
        }

        return [
            'type' => $type,
            'value' => $value,
        ];
    }
}
