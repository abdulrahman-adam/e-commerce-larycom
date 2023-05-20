<?php


namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartServices 
{
    private $session;
    private $repoProduct;
    public function __construct(SessionInterface $session, ProductRepository $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }



    // On ajoute un article au mon panier
    public function addToCart($id) //: void
    {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            // produit déja dans le panier
            $cart[$id]++; 
        } else {
            // le produit n'est pas encore dans le panier 
            $cart[$id] = 1;
        }
        $this->updateCart($cart);
    }


    // On supprime un article de mon panier
    public function deleteFromCart($id)
    {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            // produit déja dans le panier
            if($cart[$id] > 1) {
                // produit existe plus d'une fois 
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
        $this->updateCart($cart);
    }

    // On supprime mon panier
    public function deleteAllToCart($id)
    {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            // produit déja dans le panier
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }

    // On supprime  tout l'article dans la même ligne de mon panier
    public function deleteCart()
    {
        $this->updateCart([]);
    }

    // On mettre mon panier
    public function updateCart($cart)
    {
        $this->session->set('cart', $cart);
    }

    // On récupère mon panier
    public function getCart()
    {
        return $this->session->get('cart', []);
    }


    public function getFullCart() 
    {
        $cart = $this->getCart();

        $fullCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->repoProduct->find($id);
            if($product) {
                // produit récupère avec succès
                $fullCart[] = [
                    'quantity' => $quantity,
                    'product' => $product,
                ];
            } else {
                // si id incorrect supprimer le produit dans mon panier 
                $this->deleteFromCart($id);
            }
        }
    }

}