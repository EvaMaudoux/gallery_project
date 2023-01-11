<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{

    #[Route('/admin/users', name: 'app_admin_users')]
    public function adminUsers(UserRepository $repository): Response
    {
        $users = $repository->findBy(
            [],
            ['lastName' => 'ASC']
        );
        return $this->render('admin/users/users.html.twig', [
            'users' => $users,
        ]);
    }
}
