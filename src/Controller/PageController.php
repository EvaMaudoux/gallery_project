<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    /**
     * @return Response
     */
    #[Route('/team', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('page/team.html.twig');
    }
}
