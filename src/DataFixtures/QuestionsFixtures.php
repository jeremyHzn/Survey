<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionsFixtures extends Fixture
{
    public const COUNT_OF_QUESTIONS = 3;

    public function load(ObjectManager $manager)
    {

        $this->manager = $manager;
        $this->loadQuestion($type, $value, $manager);
        $manager->flush();
    }

    public function loadQuestion(Questions $type, Questions $value, $manager)
    {
        $parent = $this->createQuestion('SAV', null, $manager);

        $this->createQuestion('La personne que vous avez eu au téléphone était-elle audible ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone était-elle aimable ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?', $parent, $manager);
    }

    public function createQuestion(string $subject, ?Questions $parent, ObjectManager $manager): Questions
    {
        $type = $this->getReference('type-');
        $question = new Questions($value, $type);
        $question->setSubject($subject);
        $question->setParent($parent);
        $manager->persist($question);

        return $question;
    }

}