<?php

namespace App\Controller\admin;

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

class AdminPaintingsController extends AbstractController
{
    /**
     * @param PaintingRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/paintings', name: 'app_admin_paintings')]
    public function adminPaintings(PaintingRepository $repository, PaginatorInterface $paginator, Request $request): Response
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
        return $this->render('admin/paintings/paintings.html.twig', [
            'paintings' => $pagination,
        ]);
    }


    /**
     * @param Painting $painting
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('admin/delPainting/{id}', name: 'app_admin_del_painting')]
    public function delPainting(Painting $painting, EntityManagerInterface $manager) : Response
    {
        $manager->remove($painting);
        $manager->flush();

        $this->addFlash(
            'info',
            'Oeuvre supprimée avec succès!'
        );

        return $this->redirectToRoute('app_admin_del_painting');
    }


    /**
     * @param EntityManagerInterface $manager
     * @param Painting $painting
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/editPainting/{id}', name:'app_admin_edit_painting')]
    public function editPainting(EntityManagerInterface $manager, Painting $painting, Request $request) : Response
    {
        $form = $this->createForm(PaintingType::class, $painting);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $painting->createSlug();
            $manager->flush();

            $this->addFlash(
                'info',
                'Oeuvre mise à jours avec succès!'
            );

            return $this->redirectToRoute('app_admin_edit_painting');
        }
        return $this->renderForm('admin/paintings/editPainting.html.twig', [
            'form' => $form,
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('admin/newPainting', name:'app_admin_new_painting')]
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

            return $this->redirectToRoute('app_admin_new_painting');
        }

        return $this->renderForm('admin/paintings/newPainting.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('admin/newCategory', name:'app_admin_new_category')]
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

            return $this->redirectToRoute('app_admin_new_category');
        }

        return $this->renderForm('admin/paintings/newCategory.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('admin/newTechnical', name:'app_admin_new_technical')]
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

            return $this->redirectToRoute('app_admin_new_technical');
        }

        return $this->renderForm('admin/paintings/newTechnical.html.twig', [
            'form' => $form
        ]);
    }

}
