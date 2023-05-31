<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class FormsFixtures.
 */
class FormsFixtures extends Fixture implements DependentFixtureInterface, DataProviderInterface
{
    /**
     * @return string[]
     *                  return the dependencies of this class
     */
    public function getDependencies()
    {
        return [
            QuestionsFixtures::class,
        ];
    }

    /**
     * @return void
     *              load loadForms() and flush to bdd
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadForms();
        $manager->flush();
    }

    /**
     * @return void
     *              foreach all emails in dataProvider and create a new form with the value of the dataProvider
     */
    public function loadForms(): void
    {
        // get all emails
        $emails = $this->dataProvider();

        foreach ($emails as $key => $value) {

            $this->createForms(
                $value,
                QuestionsFixtures::QUESTION_REFERENCE_PREFIX.$key
            );
        }
    }

    /**
     * @return Forms
     *               create a new form and set emails
     */
    public function createForms(
        string $email,
        string $questionReferenceKey,
    ): Forms {
        $question = $this->helperGetQuestionsReferenceKey($questionReferenceKey);
        $form = new Forms($email);
        $form->setQuestion($question);
        $this
            ->manager
            ->persist($form);

        return $form;
    }

    /**
     * @return string[]
     *                  return an array of emails
     */
    public function dataProvider(): array
    {
        return [
            'user.mail@gmail.com',
        ];
    }

    private function helperGetQuestionsReferenceKey(
        string $questionReferenceKey
    ): Questions {
        $question = $this->getReference($questionReferenceKey);
        if (false === $question instanceof Questions) {
            throw new \LogicException('helperGetQuestionsReferenceKey : Reference key of Question not found');
        }

        return $question;
    }
}
