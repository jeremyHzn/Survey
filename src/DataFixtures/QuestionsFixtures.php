<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionsFixtures extends Fixture
{
    public const COUNT_OF_QUESTIONS = 3;

    private ObjectManager $manager;

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
    public function loadQuestion(Questions $type, Questions $value)
    {
        $parent = $this->createQuestion('SAV', null, $manager);

        $this->createQuestion('La personne que vous avez eu au téléphone était-elle audible ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone était-elle aimable ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?', $parent, $manager);
    }

    /**
     * @param string $subject
     * @param Questions|null $parent
     * @return Questions
     * function createQuestion is private because it is only used in this class
     * create a new question with the value of the dataProvider
     * set the subject of the question
     * set the parent of the question
     * persist the question
     * return the question
     */
    public function createQuestion(string $subject, ?Questions $parent): Questions
    {
        $type = $this->getReference(TypesFixtures::TYPE_REFERENCE_PREFIX);
        $value = $this->getReference(ValuesFixtures::VALUE_REFERENCE_PREFIX);

        $question = new Questions($value, $type);

        $question->setSubject($subject);
        $question->setParent($parent);
        $this->manager->persist($question);

        return $question;
    }

}