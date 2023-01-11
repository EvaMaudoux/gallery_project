<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/articles', name: 'app_articles')]
    public function articles(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $article = $articleRepository->findBy(
            [],
            ['name' => 'ASC']
        );

        $pagination = $paginator->paginate(
            $article,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('article/articles.html.twig', [
            'articles' => $pagination
        ]);
    }


    /**
     * @param Article $article
     * @return Response
     */
    #[Route('/article/{slug}', name: 'app_article')]
    public function article(Article $article): Response
    {
        return $this->render('article/article.html.twig', [
            'article' =>$article,
        ]);
    }

}
