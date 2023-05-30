<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(QuestionsRepository $questionsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'questions' => $questionsRepository->findAll(),
        ]);
    }
}
