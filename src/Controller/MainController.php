<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $question = new Questions();

        $questionForm = $this->createForm(QuestionsFormType::class, $question);

        return $this->render('main/index.html.twig', [
            'questionForm' => $questionForm->createView(),
        ]);
    }
}