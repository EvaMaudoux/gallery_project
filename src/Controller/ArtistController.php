<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use App\Repository\PaintingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    /**
     * @param ArtistRepository $artistRepository
     * @param PaintingRepository $paintingRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/artists', name: 'app_artists')]
    public function paintings(ArtistRepository $artistRepository, PaintingRepository $paintingRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $artists = $artistRepository->findBy(
            [],
            ['lastName' => 'ASC']
        );
        $paintings = $paintingRepository->findBy(
            [],
            ['title' => 'ASC']
        );

        $pagination = $paginator->paginate(
            $artists,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('artist/artists.html.twig', [
            'artists'    => $pagination,
            'paintings'  => $paintings
        ]);
   }

    /**
     * @param Artist $artist
     * @return Response
     */
    #[Route('/artist/{slug}', name: 'app_artist')]
    public function artist(Artist $artist, PaintingRepository $paintingRepository): Response
    {

        $paintings = $paintingRepository->findBy(
            [],
            ['title' => 'ASC']
        );

        return $this->render('artist/artist.html.twig', [
            'paintings' => $paintings,
            'artist' => $artist,
        ]);
    }

}
