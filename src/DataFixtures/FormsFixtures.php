<?php

namespace App\DataFixtures;

use App\Entity\Forms;
use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class FormsFixtures extends Fixture implements DependentFixtureInterface, DataProviderInterface
{
    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            QuestionsFixtures::class,
        ];
    }

    /**
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadForms();
        $manager->flush();
    }

    /**
     * @return void
     */
    public function loadForms(): void
    {
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
     */
    public function createForms(string $email, string $questionReferenceKey): Forms
    {
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
     */
    public function dataProvider(): array
    {
        return [
            'user.mail@gmail.com',
        ];
    }

    /**
     * @return Questions
     */
    private function helperGetQuestionsReferenceKey(string $questionReferenceKey): Questions
    {
        $question = $this->getReference($questionReferenceKey);
        if (false === $question instanceof Questions) {
            throw new \LogicException('helperGetQuestionsReferenceKey : Reference key of Question not found');
        }

        return $question;
    }
}
