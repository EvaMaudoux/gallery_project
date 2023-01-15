<?php

namespace App\Controller;


use App\Entity\Painting;
use App\Entity\Comment;
use App\Entity\PaintingLike;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PaintingLikeRepository;
use App\Repository\PaintingRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param PaintingRepository $paintingRepository
     * @return Response
     */
    #[Route('/paintings', name: 'app_paintings')]
    public function paintings(CategoryRepository $categoryRepository, PaintingRepository $paintingRepository): Response
    {
        $categories = $categoryRepository->findBy(
            [],
            ['name' => 'ASC']
        );
        $paintings = $paintingRepository->findBy(
            [],
            ['title' => 'ASC']
        );

        return $this->render('painting/paintings.html.twig', [
            'categories'    => $categories,
            'paintings'       => $paintings
        ]);
    }


    /**
     * @param Painting $painting
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/painting/{slug}', name: 'app_painting')]
    public function painting(Painting $painting, CommentRepository $commentRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $comments = $commentRepository->findBy(
            ['painting' => $painting],
            []
        );
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment ->setPainting($painting);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'info',
                'Votre commentaire a bien été envoyé!'
            );
            return $this->redirectToRoute('app_painting',
                ['slug' => $painting->getSlug()]
            );
        }

        return $this->render('painting/painting.html.twig', [
            'painting' => $painting,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }

    /** Permet de liker ou déliker une peinture
     * @param Painting $painting
     * @param EntityManagerInterface $manager
     * @param PaintingLikeRepository $likeRepository
     * @return Response
     */
    #[Route('/painting/{id}/like', name: 'app_painting_like')]
    public function like (Painting $painting, EntityManagerInterface $manager, PaintingLikeRepository $likeRepository) : Response
    {
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté
        if(!$user) return $this->json([
            'code' => 403,
            'message' => 'Accès non autorisé. Connecte-toi!'
        ], 403);

        // Si la peinture est likée par cet user
        if ($painting->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy([
                'painting' => $painting,
                'user' => $user,
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'le like a bien été supprimé',
                'likes' => $likeRepository->count(['painting' =>$painting])
            ], 200);
        }

        $like = new PaintingLike();
        $like->setPainting($painting)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();

         return $this->json([
            'code' => 200,
            'message' => 'le like a bien été ajouté',
            'likes' =>  $likeRepository->count(['painting' =>$painting])
        ], 200);
    }

    #[Route('/wishlist', name: 'app_wishlist')]
    public function paintingsLiked (PaintingRepository $repository) {
        $user = $this->getUser();

        $paintings = $repository->findLikedByUser($user);
        return $this->render('user/wishlist.html.twig', [
            'paintingsLiked' => $paintings,
        ]);
    }
}