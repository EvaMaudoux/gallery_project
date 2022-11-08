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
    #[Route('/articles', name: 'articles')]
    public function articles(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $article = $articleRepository->findBy(
            [],
            ['name' => 'ASC']
        );

        $pagination = $paginator->paginate(
            $article,
            $request->query->getInt('page', 1), /*page number*/
            8
        );
        return $this->render('article/articles.html.twig', [
            'articles' => $pagination
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/article/{slug}', name: 'article')]
    public function course(Article $article): Response
    {
        return $this->render('article/article.html.twig', [
            'article' =>$article
        ]);
    }

}
