<?php

namespace App\Controller;


use App\Entity\Painting;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PaintingRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaintingController extends AbstractController
{
    #[Route('/paintings', name: 'paintings')]
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
     * @return Response
     */
    #[Route('/painting/{slug}', name: 'painting')]
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
            return $this->redirectToRoute('painting',
                ['slug' => $painting->getSlug()]
            );
        }

        return $this->render('painting/painting.html.twig', [
            'painting' => $painting,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}