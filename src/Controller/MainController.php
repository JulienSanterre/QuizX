<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use App\Repository\ResponsesRepository;
use App\Repository\TagsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(QuestionsRepository $questionsRepository, TagsRepository $tagsRepository,ResponsesRepository $responsesRepository)
    {
        return $this->render('main/index.html.twig', [
            'questions' => $questionsRepository->findAllByDescCreatedAt(),
            'tags' => $tagsRepository->findAll(),
            'responses' => $responsesRepository->findAll(),
        ]);
    }
}
