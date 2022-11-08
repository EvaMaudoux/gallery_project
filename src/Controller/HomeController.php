<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(PaintingRepository $paintingRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        $painting = $paintingRepository->findBy(
            [],
            [],
            4
        );

        $articles = $articleRepository->findBy(
            [],
            ['created_at' => 'DESC'],
            4
        );

        $category = $categoryRepository->findAll();
        return $this->render('home/home.html.twig',
            [
                'paintings'   => $painting,
                'category' => $category,
                'articles' => $articles
            ]);
    }

}
