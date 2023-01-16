<?php

namespace App\Controller\user;

use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function cart(SessionInterface $session, PaintingRepository $repository): Response
    {
        $panier = $session->get('panier', []);

        // On "fabrique" les données;
        $dataPanier = [];
        $total = 0;

        // récupération des infos du panier + infos du produit (id)
        foreach ($panier as $id => $quantity) {
            $painting = $repository->find($id);


            $dataPanier[] = [
                'painting' => $painting,
                'quantity' => $quantity
            ];
            $total += ($painting->getPrice()) * $quantity;
    }

        return $this->render('user/cart.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total,
        ]);

    }


    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addCart(Painting $painting, SessionInterface $session)
    {
        // récupération des données contenues dans le panier actuel
        $panier = $session->get('panier', []);
        $id = $painting->getId();

        // sauvegarde des données du nouveau panier dans la session
        $session->set('panier', $panier);

        $this->addFlash(
            'Succes',
            'Le tableau a bien été ajouté du panier!'
        );

        // dd($session);
        return $this->redirectToRoute('app_paintings');
    }


    #[Route('/cart/del/{id}', name: 'app_cart_del')]
    public function delCart(Painting $painting, SessionInterface $session)
    {
        // récupération des données contenues dans le panier actuel
        $panier = $session->get('panier', []);
        $id = $painting->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // sauvegarde des données du nouveau panier dans la session
        $session->set('panier', $panier);
        $this->addFlash(
            'info',
            'Le tableau a bien été retiré du panier!'
        );

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/delAll/', name: 'app_cart_delAll')]
    public function delAll(SessionInterface $session)
    {
        // récupération des données contenues dans le panier actuel
        $session->remove('panier');

        return $this->redirectToRoute('app_cart');
    }
}
