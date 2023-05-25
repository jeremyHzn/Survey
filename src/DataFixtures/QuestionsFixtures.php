<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class QuestionsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

       $question = $this->getReference("question-{$id}");

        $this->loadQuestion($type, $value, $manager);
        $manager->flush();

        $questions1Type = $this->addReference("1",$type);
        $questions1Value = $this->addReference("2",$value);
    }

    public function loadQuestion(Questions $type, Questions $value, ObjectManager $manager)
    {
        $parent = $this->createQuestion('SAV', null, $manager);

        $this->createQuestion('La personne que vous avez eu au téléphone était-elle audible ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone était-elle aimable ?', $parent, $manager);
        $this->createQuestion('La personne que vous avez eu au téléphone a-t-elle réussi à résoudre votre problème ?', $parent, $manager);
    }

    public function createQuestion(string $subject, ?Questions $parent, ObjectManager $manager): Questions
    {

        $value = $this->addReference('value-', $parent);
        $type = $this->getReference('dynamic-');
        $question = new Questions($value, $type);
        $question->setSubject($subject);
        $question->setParent($parent);
        $manager->persist($question);

        return $question;
    }

}