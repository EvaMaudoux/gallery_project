<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Painting;
use App\Entity\Technical;
use App\Form\CategoryType;
use App\Form\PaintingType;
use App\Form\TechnicalType;
use App\Repository\PaintingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function paintings(PaintingRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $paintings = $repository->findBy(
            [],
            ['title'=> 'ASC']
        );
        $pagination = $paginator->paginate(
            $paintings,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/admin.html.twig', [
            'paintings' => $pagination,
        ]);
    }



    #[Route('admin/delete/{id}', name: 'delete')]
    public function delete(Painting $painting, EntityManagerInterface $manager)
    {
        $manager->remove($painting);
        $manager->flush();

        $this->addFlash(
            'info',
            'Oeuvre supprimée avec succès!'
        );

        return $this->redirectToRoute('admin');
    }



    #[Route('/admin/edit/{id}', name:'edit')]
    public function edit(EntityManagerInterface $manager, Painting $painting, Request $request) {
        $form = $this->createForm(PaintingType::class, $painting);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $painting->createSlug();
            $manager->flush();

            $this->addFlash(
                'info',
                'Oeuvre mise à jours avec succès!'
            );

            return $this->redirectToRoute('admin');
        }
        return $this->renderForm('admin/editPainting.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('admin/newPainting', name:'newPainting')]
    public function newPainting(Request $request, EntityManagerInterface $manager) : Response
    {
        $paint = new Painting;
        $form = $this->createForm(PaintingType::class, $paint);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $paint  ->setCreated(new \DateTimeImmutable())
                    ->setImageName('60.png');
            $manager->persist($paint);
            $manager->flush();

            $this->addFlash(
                'info',
                'Oeuvre ajoutée avec succès!'
            );

            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/newPainting.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('admin/newCategory', name:'newCategory')]
    public function newCategory(Request $request, EntityManagerInterface $manager) : Response
    {
        $cat = new Category;
        $form = $this->createForm(CategoryType::class, $cat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($cat);
            $manager->flush();

            $this->addFlash(
                'info',
                'Catégorie ajoutée avec succès!'
            );

            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/newCategory.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('admin/newTechnical', name:'newTechnical')]
    public function newTechnical(Request $request, EntityManagerInterface $manager) : Response
    {
        $tech = new Technical;
        $form = $this->createForm(TechnicalType::class, $tech);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($tech);
            $manager->flush();

            $this->addFlash(
                'info',
                'Technique ajoutée avec succès!'
            );

            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/newTechnical.html.twig', [
            'form' => $form
        ]);
    }

}
