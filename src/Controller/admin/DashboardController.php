<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Artist;
use App\Entity\Comment;
use App\Entity\Painting;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Les utilisateurs', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Les peintures', 'fa-solid fa-palette', Painting::class);
        yield MenuItem::linkToCrud('Les Artistes', 'fa-solid fa-paintbrush', Artist::class);
        yield MenuItem::linkToCrud('Les Articles', 'fa-solid fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Les Commentaires', 'fa-solid fa-comment', Comment::class);
    }
}
