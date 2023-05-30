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
 * Class QuestionsFixtures
 */
final class QuestionsFixtures extends Fixture implements DependentFixtureInterface, DataProviderInterface
{
    /**
     * indicate the number of questions
     */
    public const COUNT_OF_QUESTIONS = 4;
    public const QUESTION_REFERENCE_PREFIX = 0;
    private ObjectManager $manager;

    /**
     * indicate the return order of fixtures
     */
    public function getDependencies(): iterable
    {
        return [
            TypesFixtures::class,
            ValuesFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     * @return void
     * use loadQuestion() to get data and add to bdd
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadQuestions();

        $manager->flush();
    }

    /**
     * @return void
     * foreach all subjects in dataProvider and create a new question with the value of the dataProvider
     *
     */
    public function loadQuestions(): void
    {
        // define $parent as null by default
        $parent = null;

        // get all subjects
        $subjects = $this->dataProvider();

        // foreach all subjects
        foreach ($subjects as $key => $subject) {
            // define $typeReferenceKey as the type reference key
            $typeReferenceKey = TypesFixtures::TYPE_REFERENCE_PREFIX.$key;
            // define $valueReferenceKey as the value reference key
            $valueReferenceKey = ValuesFixtures::VALUE_REFERENCE_PREFIX.$key;
            // define $questionReferenceKey as the question reference key
            $questionReferenceKey = self::QUESTION_REFERENCE_PREFIX.$key;
            // if $key is equal to 0
            if ($key === 0) {
                // create a new question with the value of the dataProvider
                $parent = $this->createQuestion(
                    // subject
                    subject: $subject,
                    // typeReferenceKey
                    typeReferenceKey: $typeReferenceKey,
                    // valueReferenceKey
                    valueReferenceKey: $valueReferenceKey,
                    questionReferenceKey: $questionReferenceKey
                );
                continue;
            }
            // create a new question with the value of the dataProvider
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
     * @param string $subject
     * @param Questions|null $parent
     * @param string|null $typeReferenceKey
     * @param string|null $valueReferenceKey
     * @return Questions
     * create a new question with the value of the dataProvider
     */
    public function createQuestion(
        // define properties
        string $subject,
        ?Questions $parent = null,
        ?string $typeReferenceKey = null,
        ?string $valueReferenceKey = null,
        ?string $questionReferenceKey = null
    ): Questions {
        // get the type and value instances or throw an exception
        [
            'type' => $type,
            'value' => $value,
        ] = $this->getTypesAndValuesReferencesKey(
            $typeReferenceKey,
            $valueReferenceKey
        );
        // create a new question with the value of the dataProvider
        $question = new Questions($type, $value);

        // set the category of the question
        $question

            ->setSubject($subject)
            ->setParent($parent);

        // persist the question
        $this
            ->manager
            ->persist($question);

        // if $questionReferenceKey is not null
        if ($questionReferenceKey !== null) {
            // add a reference to the question
            $this->addReference($questionReferenceKey, $question);
        }

        // return the question
        return $question;
    }

    /**
     * @return array
     * return the dataProvider
     */
    public function dataProvider(): array
    {
        // return the dataProvider
        return [
            // 0
            'SAV',
            // 1
            'La personne que vous avez eu au téléphone était-elle audible ?',
            // 2
            'La personne que vous avez eu au téléphone était-elle aimable ?',
            // 3
            'La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?',
        ];
    }

    /**
     * @param string $typeReferenceKey
     * @param string $valueReferenceKey
     * @return iterable
     * @throws \LogicException
     * get the type and value instances or throw an exception
     *
     */
    private function getTypesAndValuesReferencesKey(
        string $typeReferenceKey,
        string $valueReferenceKey
    ): iterable {
        // get the type and value instances or throw an exception
        $type = $this->getReference($typeReferenceKey);
        $value = $this->getReference($valueReferenceKey);

        // if $type is not an instance of Types or $value is not an instance of Values
        if (
            false === $type instanceof Types
            ||
            false === $value instanceof Values
        ) {
            // throw an exception
            throw new \LogicException('You have a problem on references.');
        }

        // return the type and value instances
        return [
            'type' => $type,
            'value' => $value,
        ];
    }
}
