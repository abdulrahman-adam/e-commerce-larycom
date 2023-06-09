<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressFormType;
use App\Controller\CartController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    // On ajoute une address ou cette function fait ajouter une adresse
    #[Route('/compte/add', name: 'account_address_add')]
    public function add(CartController $cart, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if($cart) {
                return $this->redirectToRoute('app_order');

            } else {

                return $this->redirectToRoute('app_account_address');
            }

        }
        return $this->render('account/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     // On modifier une address ou cette function fait modification une adresse
     #[Route('/compte/modifier/{id}', name: 'account_address_edit')]
     public function edit($id, Request $request): Response
     {

         $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

         if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
         }

         $form = $this->createForm(AddressFormType::class, $address);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
          
             $this->entityManager->flush();
             return $this->redirectToRoute('app_account_address');
         }
         return $this->render('account/add.html.twig', [
             'form' => $form->createView(),
         ]);
    }


     // On Supprime une address ou cette function fait supprimer une adresse
     #[Route('/compte/delete/{id}', name: 'account_address_delete')]
     public function delete($id): Response
    {

        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

         if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_account_address');
       
    }
}
