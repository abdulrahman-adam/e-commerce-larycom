<?php

namespace App\Controller;

use App\Entity\Commander;
use App\Form\CommanderFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommanderController extends AbstractController
{
    #[Route('/commander', name: 'app_commander')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {
        $commander = new Commander();

            $form = $this->createForm(CommanderFormType::class, $commander);

            // Associe les données provenant de $_Post à notre formulaire 
            // et plus particulièrement à l'accueil assciée 
            $form->handleRequest($request);
            // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
            //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
            //pour chaque propriété
            if($form->isSubmitted() && $form->isValid()) {

                $commander = $form->getData();

                $picture = $form->get('picture')->getData();
                if($picture) {
                    // On générer un nouveau nom de fichier pour éviter les fichiers existants
                    $imageName = md5(uniqid()). "." .$picture->guessExtension();
                    // On déplace le fichier dans le dossier définit par le paramètre upload_dir 
                    // On copie ce fichier avec le nom qui vient d'être généré
                    $commander->setPicture($imageName);
                    // On enregistre en base de donnée le nouveau nom de fichier
                    $picture->move($this->getParameter('upload_dir'), $imageName); 
                }
                // enregistrer les données
                $em = $manager->getManager();
                // il permets de mettre file d’annteds les element va ajouter en base de données
                $em->persist($commander);
                // il permets d’excuter tous qui en attendre
                $em->flush();
                // Ajoute un messages flash pour prévenir du resultats de l'opération
                $this->addFlash("success", "Nous avons réçu votre commandé, nous mettons votre commadé en place, à bientôt chez larycom");
                return $this->redirectToRoute('app_product');

            }
        return $this->renderForm('commander/index.html.twig', [
            'formCommander' => $form,
        ]);
    }
}
