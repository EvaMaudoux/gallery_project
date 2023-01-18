<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Painting;
use App\Entity\Slider;
use App\Entity\Technical;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;




class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator) {
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(PaintingCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        // Section users
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
        yield MenuItem::section('Utilisateurs', 'fa-solid fa-user');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les utilisateurs', 'fa-solid fa-eye', User::class),
        ]);
        }

        // Section paintings
        yield MenuItem::section('Tableaux', 'fa-solid fa-palette');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les peintures', 'fa-solid fa-eye', Painting::class),
             MenuItem::linkToCrud('Ajouter une peinture', 'fa-solid fa-plus', Painting::class)->setAction(Crud::PAGE_NEW),
        ]);

        // Section catégories de peinture
        yield MenuItem::section('Catégories de peinture', 'fa-solid fa-palette');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fa-solid fa-eye', Category::class),
            MenuItem::linkToCrud('Ajouter une catégorie', 'fa-solid fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
        ]);

        // Section techniques de peinture
        yield MenuItem::section('Techniques de peinture', 'fa-solid fa-palette');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir les techniques', 'fa-solid fa-eye', Technical::class),
            MenuItem::linkToCrud('Ajouter une technique', 'fa-solid fa-plus', Technical::class)->setAction(Crud::PAGE_NEW),
        ]);


        // Sections artists
        yield MenuItem::section('Artistes', 'fa-solid fa-paintbrush');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les artistes', 'fa-solid fa-eye', Artist::class),
             MenuItem::linkToCrud('Ajouter un artiste', 'fa-solid fa-plus', Artist::class)->setAction(Crud::PAGE_NEW),
        ]);

        // Section Articles
        yield MenuItem::section('Articles', 'fa-solid fa-newspaper');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les articles', 'fa-solid fa-eye', Article::class),
             MenuItem::linkToCrud('Créer un nouvel article', 'fa-solid fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
        ]);

        // Section slider
        yield MenuItem::section('Slider', 'fa-solid fa-image');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les images du slider', 'fa-solid fa-eye', Slider::class),
             MenuItem::linkToCrud('Ajouter une image au slider', 'fa-solid fa-plus', Slider::class)->setAction(Crud::PAGE_NEW),
        ]);

        // Section comments
        yield MenuItem::section('Commentaires', 'fa-solid fa-comment');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Voir les commentaires', 'fa-solid fa-eye', Comment::class),
        ]);

       // Retour vers la partie publique
        yield MenuItem::linktoRoute('Retour vers la partie publique du site', 'fas fa-home', 'app_home');

    }
}
