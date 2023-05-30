<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class FormsFixtures
 */
class FormsFixtures extends Fixture implements DependentFixtureInterface, DataProviderInterface
{
    /**
     * @return string[]
     * return the dependencies of this class
     */
    public function getDependencies()
    {
        return [
            QuestionsFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     * @return void
     * load loadForms() and flush to bdd
     */
    public function load(ObjectManager $manager) :void
    {
        $this->manager = $manager;
        $this->loadForms();
        $manager->flush();
    }

    /**
     * @return void
     * foreach all emails in dataProvider and create a new form with the value of the dataProvider
     */
    public function loadForms() :void
    {
        // get all emails
        $emails = $this->dataProvider();

        foreach ($emails as $value) {
             $this->createForms(
                 $value,

             );
        }
    }

    /**
     * @param string $email
     * @return Forms
     * create a new form and set emails
     */
    public function createForms(
        string $email,
        string $questionReferenceKey = null,
        ):Forms {
        $this->getQuestionsIdReferenceKey($questionReferenceKey);

        $form = new Forms();
        $form->setEmail($email);
        $this
            ->manager
            ->persist($form);
        return $form;
    }

    /**
     * @return string[]
     * return an array of emails
     */
    public function dataProvider() :array
    {
        return [
            "user.mail@gmail.com"
        ];
    }

    private function getQuestionsIdReferenceKey(
        string $questionReferenceKey
    ): array
    {
       $questionId = $this->getReference($questionReferenceKey);

       if ($questionId === null) {
           throw new \LogicException('Question id is null');
       }

       return [
           "question_id" => $questionId
       ];
    }
}
