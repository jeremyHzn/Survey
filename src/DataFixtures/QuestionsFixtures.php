<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class QuestionsFixtures
 */
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

    /**
     * @param ObjectManager $manager
     * @return void
     * function load is public because it is used in the class Fixtures
     * set the manager to the manager
     * call the function loadQuestion
     * flush the manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadQuestion($type, $value);
        $manager->flush();
    }

    /**
     * @param Questions $type
     * @param Questions $value
     * @return void
     * function loadQuestion is private because it is only used in this class
     * create a parent question
     * create a child question with the parent question
     * persist the child question
     * create a child question with the parent question
     * persist the child question
     * create a child question with the parent question
     * persist the child question
     * flush the manager
     */
    public function loadQuestions(): void
    {
        $parent = null;

        $subjects = $this->dataProvider();

        foreach ($subjects as $key => $subject) {
            $typeReferenceKey = TypesFixtures::TYPE_REFERENCE_PREFIX . $key;

            $valueReferenceKey = ValuesFixtures::VALUE_REFERENCE_PREFIX . $key;

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
        string     $subject,
        ?Questions $parent = null,
        ?string    $typeReferenceKey = null,
        ?string    $valueReferenceKey = null
    ): Questions
    {
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
    ): \Traversable|array
    {
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