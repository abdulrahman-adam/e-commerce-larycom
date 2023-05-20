<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Form\OrderFormType;
use App\Controller\CartController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(ProductRepository $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderFormType::class, null, [
            'user' => $this->getUser(),
        ]);
            return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getSubscribedServices(),
        ]);
    }
}
