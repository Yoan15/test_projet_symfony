<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;

    public function __construct(ArticleRepository $repoArticle, 
                                CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $categories = $this->repoCategory->findAll();
        $articles = $this->repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
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

    #[Route('/articlesByCategory/{id}', name: 'articles_category')]
    public function articlesByCategory(?Category $category): Response
    {
        if($category){
            $articles = $category->getArticles()->getValues();
        }else{
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategory->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    // #[Route('/addArticle', name:'addArticle')]
    // public function addArticle(Article $article): Response
    // {

    // }
}
