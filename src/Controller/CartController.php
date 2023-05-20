<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        // On récupère le panier avec la méthode get, si mon panier vide je récupère un 
        //tableau vide
        $panier = $session->get("panier", []);
        // dd($panier);
        // On fabrique les données 
        $dataPanier = [];
        $total = 0;
        // On boucler sur mon panier 
        // Je vais récupèrer l' id et la quantite
        foreach($panier as $id => $quantite) {
                // On récupère les produits dans la page d'accueil
                // pour récupère les produits j'besoin le repsitory du 
                //controller qui affiche mes produis
                // Avec cette méthode je récupère un produits
            $product = $productRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }
        return $this->render('cart/index.html.twig', 
            compact("dataPanier", "total"));
    }
    #[Route("/add/{id}", name: 'add_cart')]
    // La méthode SessionInterface permets d’acceder à la session niveau du symfony
    public function add($id, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        // Onsauvegarde dans la session 
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_cart");
    }

    #[Route("/remove/{id}", name: 'remove_cart')]
    public function remove($id, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        if(!empty($panier[$id])) {
            if($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        } 
        // Onsauvegarde dans la session 
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_cart");
    }
    
    #[Route("/delete/{id}", name: 'delete_cart')]
    public function delete($id, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        if(!empty($panier[$id])) {
            unset($panier[$id]);
        } 
        // Onsauvegarde dans la session 
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_cart");
    }

    #[Route("delete/", name: 'all_delete_cart')]
    public function deleteAll(SessionInterface $session)
    {
        $session->set("panier", []);
        // $session->remove("panier");
        return $this->redirectToRoute("app_cart");
    }
}
