<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionsFixtures extends Fixture
{
    public const COUNT_OF_QUESTIONS = 3;

    private ObjectManager $manager;

    public function load(ObjectManager $manager)
    {
        $this->loadQuestion($type, $value);
        $manager->flush();
    }

    public function loadQuestion(Questions $type, Questions $value)
    {
        $parent = $this->createQuestion('SAV', null, $manager);

        $this->createQuestion('La personne que vous avez eu au téléphone était-elle audible ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone était-elle aimable ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?', $parent, $manager);
    }

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