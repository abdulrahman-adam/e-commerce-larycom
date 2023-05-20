<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        // Associe les données provenant de $_Post à notre formulaire 
        // et plus particulièrement à le produit assciée 
        $form->handleRequest($request);
        // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
        //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
        //pour chaque propriété
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            // enregistrer les données
            $em = $manager->getManager();
            // il permets de mettre file d’annteds les element va ajouter en base de données
            $em->persist($contact);
            // il permets d’excuter tous qui en attendre
            $em->flush();
            // Ajoute un messages flash pour prévenir du resultats de l'opération
            $this->addFlash('success', 'votre message a bien été envoyé');
            return $this->redirectToRoute('app_product');
        }

        return $this->renderForm('contact/index.html.twig', [
            'contactForm' => $form,
        ]);
    }
}
