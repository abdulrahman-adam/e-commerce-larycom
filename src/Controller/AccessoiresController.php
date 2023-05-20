<?php

namespace App\Controller;

use App\Entity\Accessoires;
use App\Form\AccessoiresFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessoiresController extends AbstractController
{
    #[Route('/accessoires', name: 'app_accessoires')]
    public function index(ManagerRegistry $manager): Response
    {
        $accessoire = $manager->getRepository(Accessoires::class)->findAll();

        return $this->render('accessoires/index.html.twig', [
            'accessoireList' => $accessoire,
        ]);
    }


    
    #[Route('/accessoires/{id}', name: 'single_accessoires', requirements: ['id' => '[0-9]+'])]
    public function single($id, ManagerRegistry $manager): Response
    {
        // charge un accessoire en function de i'id reçu
        $accessoire = $manager->getRepository(Accessoires::class)->find($id);
        // si on trouve l'accessoire, on affiche la page 
        if ($accessoire) {
            return $this->render('accessoires/single.html.twig', [
                'accessoires' => $accessoire
            ]);
        } else {
            $this->addFlash("danger", "L'accessoire démandée n'exsite pas");
            // Sinon on redirect l'utilisateur vers la pag contenant touts les accessoires
            return $this->redirectToRoute('app_accessoires');
        }
    }


    #[Route('/accessoires/save', name: 'save_accessoires', methods: ["GET", "POST"])]
    #[IsGranted(data:'ROLE_ADMIN', message: "Vous n'avez pas les autorisations nécessaire", statusCode: 403)]

    public function save(Request $request, ManagerRegistry $manager): Response
    {
        // On créé un nouveau accessoire
        $accessoire = new Accessoires();
        // ON créé le formulaire auquel on associe l'accessoire qui récupérationles information
        $form = $this->createForm(AccessoiresFormType::class, $accessoire);
        // Associe les données provenant de $_Post à notre formulaire 
        // et plus particulièrement à l'accessoire assciée 
        $form->handleRequest($request);
        // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
        //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
        //pour chaque propriété
        if ($form->isSubmitted() && $form->isValid()) {
            $accessoire = $form->getData();
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
                $accessoire->setPicture($imageName);
            }
            // enregistrer les données
            $em = $manager->getManager();
            // il permets de mettre file d’annteds les element va ajouter en base de données
            $em->persist($accessoire);
            // il permets d’excuter tous qui en attendre
            $em->flush();
            // Ajoute un messages flash pour prévenir du resultats de l'opération
            $this->addFlash("success", "L'accessoire a bien été ajouté");
            return $this->redirectToRoute('app_accessoires');
        }
        return $this->renderForm('accessoires/save.html.twig', [
            'formAccessoire' => $form,
            // 'accessoire' => $accessoire
        ]);
    }



    

    #[Route('/accessoires/{id}/update', name: 'update_accessoires', requirements: ['id' => "[0-9]+"], methods: ["GET", "POST"])]
    public function update($id, ManagerRegistry $manager, Request $request): Response
    {

         // On utirise l'utilisation d'accualiser


         if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('danger', "Vous n'avez pas le droit pour modifier un accessoire");
            return $this->redirectToRoute('app_product');
        }
        $accessoire = $manager->getRepository(Accessoires::class)->find($id);

        if ($accessoire) {
        // La modification de l'image
        /**
         * Symfony s'attends à recevoir un fichier et non une chaine de caractère pour l'input file.
         * Pour corriger cette erreur, on diot se servir du nom du fichier qui est en BDD pour charger l'image qui est stockée
         * Pour ce faire, on utilise le composant File de HttpFoundation
         */
            $oldPictureExist = true;
         if (file_exists($this->getParameter('upload_dir').'/'.$accessoire->getPicture()) && !is_dir($this->getParameter('upload_dir').'/'.$accessoire->getPicture())) {
           
             $picture = new File($this->getParameter('upload_dir').'/'.$accessoire->getPicture());
             $accessoire->setPicture($picture);
             $oldPictureExist = false;
        }

            $form = $this->createForm(AccessoiresFormType::class, $accessoire);
            // Associe les données provenant de $_Post à notre formulaire 
            // et plus particulièrement à l'accessoire assciée 
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
                        unlink($this->getParameter('upload_dir').'/'.$accessoire->getPicture()->getBasename());
                    }

                    // (string) permet de préciser que l'on veut utiliser la valeur de la vaiable juste près comme une chaine de caractère
                    $accessoire->setPicture((string) $imageName);
                } else {
                    // S'il y a pas de nouveau fichier, on récupère le nom du fichier déja existant pour le restocker en BDD
                    $accessoire->setPicture($picture->getBasename());
                }


                $em = $manager->getManager();
                $em->persist($accessoire);
                $em->flush();

                $this->addFlash("success", "L'accessoire a bien été modifiée");
                return $this->redirectToRoute('app_accessoires', ['id' => $accessoire->getId()]);
            }
            return $this->renderForm('accessoires/update.html.twig', [
                'formAccessoires' => $form,
                'accessoire' => $accessoire
            ]);
        } else {
            $this->addFlash("danger", "L'accessoire' démandée n'exsite pas");
            return $this->redirectToRoute('app_accessoires');
        }
    }

    #[Route('/accessoires/{id}/delete', name: 'delete_accessoires', requirements: ['id' => "[0-9]+"], methods: ["GET"])]
    public function delete($id, ManagerRegistry $manager): Response

    {


        // On utirise l'utilisation du supprimer
        return $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $accessoire = $manager->getRepository(Accessoires::class)->find($id);

        if ($accessoire) {
            $em = $manager->getManager();
            $em->remove($accessoire);
            $em->flush();
            $this->addFlash("success", "L'accessoire a été supprimée");
        } else {

            $this->addFlash("danger", "L'accessoire démandée n'exsite pas");
        }
        return $this->redirectToRoute('app_accessoires');
    }

}
