<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {


        $services = new Services();
        $form= $this->createForm(ServicesFormType::class, $services);
        // une méthode inspecter les données va recevoir par GET ou POST 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $services = $form->getData();
             // enregistrer les données
            $em = $manager->getManager();
            // il permets de mettre file d’annteds les element va ajouter en base de données
            $em->persist($services);
            // il permets d’excuter tous qui en attendre
            $em->flush();
            $this->addFlash("success", "Merci, nous avons reçu votre message.");
            return $this->redirectToRoute('app_services');
        }
        return $this->renderForm('services/index.html.twig',[
            'formServices'=>$form
        ]);

    }
}
