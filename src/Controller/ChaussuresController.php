<?php

namespace App\Controller;

use App\Entity\Chaussures;

use App\Form\ChaussuresFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChaussuresController extends AbstractController
{
    #[Route('/chaussures', name: 'app_chaussures')]
    public function index(ManagerRegistry $manager): Response
    {
        $chaussure = $manager->getRepository(Chaussures::class)->findAll();

        return $this->render('chaussures/index.html.twig', [
            'chaussures' => $chaussure,
        ]);
    }


    #[Route('/chaussures/{id}', name: 'single_chaussures', requirements: ['id' => '[0-9]+'])]
    public function single($id, ManagerRegistry $manager): Response
    {
        // charge une chaussure en function de i'id reçu
        $chaussure = $manager->getRepository(Chaussures::class)->find($id);
        // si on trouve la chaussure, on affiche la page 
        if ($chaussure) {
            return $this->render('chaussures/single.html.twig', [
                'chaussures' => $chaussure
            ]);
        } else {
            $this->addFlash("danger", "La chaussure démandée n'exsite pas");
            // Sinon on redirect l'utilisateur vers la pag contenant touts les chaussure
            return $this->redirectToRoute('single_chaussures');
        }
    }

    
    #[Route('/chaussures/save', name: 'save_chaussures', methods: ["GET", "POST"])]
    #[IsGranted(data:'ROLE_ADMIN', message: "Vous n'avez pas les autorisations nécessaire", statusCode: 403)]

    public function save(Request $request, ManagerRegistry $manager): Response
    {
        // On créé un nouveau chaussure
        $chaussure = new Chaussures();
        // ON créé le formulaire auquel on associe la chaussure  qui récupérationles information
        $form = $this->createForm(ChaussuresFormType::class, $chaussure);
        // Associe les données provenant de $_Post à notre formulaire 
        // et plus particulièrement à la chaussure assciée 
        $form->handleRequest($request);
        // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
        //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
        //pour chaque propriété
        if ($form->isSubmitted() && $form->isValid()) {
            $bagage = $form->getData();
            // La section de l'image
            // On récupère les informations de l'image reçu à travers le form
            $picture = $form->get('picture')->getData();

            if ($picture) {
                // On génére un nouveau nom de fichier pour éviter les conflits entre les fichiers existants
                $imageName = md5(uniqid()). "." .$picture->guessExtension();
                //  On déplace ce fichier dans le dossier définit par le parametre upload_dir
                // On copie ce fichier avec le nom qui vient d'être généreé
                $picture->move($this->getParameter('upload_dir'), $imageName);
                // On enregistre en BDD le nouveau nom de fichier
                $chaussure->setPicture($imageName);
            }
            // enregistrer les données
            $em = $manager->getManager();
            // il permets de mettre file d’annteds les element va ajouter en base de données
            $em->persist($chaussure);
            // il permets d’excuter tous qui en attendre
            $em->flush();
            // Ajoute un messages flash pour prévenir du resultats de l'opération
            $this->addFlash("success", "La chaussure a bien été ajouté");
            return $this->redirectToRoute('app_chaussures');
        }
        return $this->renderForm('chaussures/save.html.twig', [
            'formChaussure' => $form,
            
        ]);
    }



      
    #[Route('/chaussures/{id}/update', name: 'update_chaussures', requirements: ['id' => "[0-9]+"], methods: ["GET", "POST"])]
    public function update($id, ManagerRegistry $manager, Request $request): Response
    {

         // On utirise l'utilisation d'accualiser
         if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('danger', "Vous n'avez pas le droit pour modifier un bagage");
            return $this->redirectToRoute('app_bagages');
        }



        $chaussure = $manager->getRepository(Chaussures::class)->find($id);

      



        if ($chaussure) {

              // La modification de l'image
        /**
         *  Symfony s'attends à recevoir un fichier et non une chaine de caractère pour l'input file
         * Pour corriger cette erreur, on diot se servir du nom du fichier qui est en BDD pour charger l'image qui est stochée
         * Pour ce faire, on utilise le composant File de HttpFoundation
         */
        $oldPictureExist = false;

        if (file_exists($this->getParameter('upload_dir').'/'.$chaussure->getPicture()) && !is_dir($this->getParameter('upload_dir').'/'.$chaussure->getPicture())) {

            $picture = new File($this->getParameter('upload_dir').'/'.$chaussure->getPicture());
            $chaussure->setPicture($picture);
            $oldPictureExist = true;

        }

        
            $form = $this->createForm(ChaussuresFormType::class, $chaussure);
            // Associe les données provenant de $_Post à notre formulaire 
            // et plus particulièrement à la chaussure assciée 
            $form->handleRequest($request);
             // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
            //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
            //pour chaque propriété
            if ($form->isSubmitted() && $form->isValid()) {

                // La modification de l'image
                // On récupère le nouveau fichier du formulaire 
                $uploadedPicture = $form->get('picture')->getData();
                // S'il y a un nouveau fichier
                if($uploadedPicture) {
                    // On génère un nouveau nom 
                    $imageName = md5(uniqid()).'.'.$uploadedPicture->guessExtension();
                    // On déplace le nouveau fichier 
                    $uploadedPicture->move($this->getParameter('upload_dir'), $imageName);

                    // On supprime l'ancien fichier 
                    if($oldPictureExist) {

                        unlink($this->getParameter('upload_dir').'/'.$chaussure->getPicture()->getBasename());
                    }
                    // (string) permet de préciser que l'on veut utiliser la valeur de la vaiable juste près comme une chaine de caractère
                    $chaussure->setPicture((string) $imageName);
                } else {
                    // S'il y a pas de nouveau fichier, on récupère le nom du fichier déja existant pour le restocker en BDD
                    $chaussure->setPicture($picture->getBasename());
                }


                $em = $manager->getManager();
                $em->persist($chaussure);
                $em->flush();

                $this->addFlash("success", "La chaussure a bien été modifiée");
                return $this->redirectToRoute('app_chaussures', ['id' => $chaussure->getId()]);
            }
            return $this->renderForm('chaussures/update.html.twig', [
                'formChaussure' => $form,
                'chaussures' => $chaussure
            ]);
        } else {
            $this->addFlash("danger", "Le bagage démandée n'exsite pas");
            return $this->redirectToRoute('app_chaussures');
        }
    }

    #[Route('/chaussures/{id}/delete', name: 'delete_chaussures', requirements: ['id' => "[0-9]+"], methods: ["GET"])]
    public function delete($id, ManagerRegistry $manager): Response

    {


        // On utirise l'utilisation du supprimer
        return $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $chaussure = $manager->getRepository(Chaussures::class)->find($id);

        if ($chaussure) {
            // dd(file_exists(__DIR__.'/../../public/img/upload/'. $chaussure->getPicture()));
            $em = $manager->getManager();
            $em->remove($chaussure);
            $em->flush();
            $this->addFlash("success", "La chaussure a été supprimée");
        } else {

            $this->addFlash("danger", "La chaussure démandée n'exsite pas");
        }
        return $this->redirectToRoute('app_chaussures');
    }


}
