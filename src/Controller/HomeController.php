<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;

    public function __construct(ArticleRepository $repoArticle)
    {
        $this->repoArticle = $repoArticle;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $articles = $this->repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'article')]
    public function article(Article $article): Response
    {
        if(!$article){
            return $this->redirectToRoute('home');
        }
        return $this->render('article/detailArticle.html.twig', [
            'article' => $article,
        ]);
    }
}
