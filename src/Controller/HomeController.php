<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\AjoutArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;
    private $manager;

    public function __construct(ArticleRepository $repoArticle, 
                                CategoryRepository $repoCategory,
                                EntityManagerInterface $manager)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
        $this->manager = $manager;
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

    #[Route('/addArticle', name:'addArticle')]
    public function addArticle(Request $addArticle): Response
    {
        $article = new Article;
        $form = $this->createForm(AjoutArticleType::class, $article);

        $form->handleRequest($addArticle);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($article);
            $this->manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('article/ajoutArticle.html.twig', [
            'controller_name' => 'Ajouter un Article',
            'form_addArticle' => $form->createView(),
        ]);
    }
}
