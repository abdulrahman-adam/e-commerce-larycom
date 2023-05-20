<?php

namespace App\Controller;

use App\Entity\Bagages;
use App\Form\BagagesFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BagagesController extends AbstractController
{
    #[Route('/bagages', name: 'app_bagages')]
    public function index(ManagerRegistry $manager): Response
    {
        $bagage = $manager->getRepository(Bagages::class)->findAll();
        return $this->render('bagages/index.html.twig', [
            'bagages' => $bagage,
        ]);
    }


    #[Route('/bagages/{id}', name: 'single_bagages', requirements: ['id' => '[0-9]+'])]
    public function single($id, ManagerRegistry $manager): Response
    {
        // charge un bagage en function de i'id reçu
        $bagage = $manager->getRepository(Bagages::class)->find($id);
        // si on trouve le bagage, on affiche la page 
        if ($bagage) {
            return $this->render('bagages/single.html.twig', [
                'bagage' => $bagage
            ]);
        } else {
            $this->addFlash("danger", "Le bagage démandée n'exsite pas");
            // Sinon on redirect l'utilisateur vers la pag contenant touts les bagages
            return $this->redirectToRoute('app_bagages');
        }
    }


    #[Route('/bagages/save', name: 'save_bagages', methods: ["GET", "POST"])]
    #[IsGranted(data:'ROLE_ADMIN', message: "Vous n'avez pas les autorisations nécessaire", statusCode: 403)]

    public function save(Request $request, ManagerRegistry $manager): Response
    {
        // On créé un nouveau bagage
        $bagage = new Bagages();
        // ON créé le formulaire auquel on associe le bagages qui récupérationles information
        $form = $this->createForm(BagagesFormType::class, $bagage);
        // Associe les données provenant de $_Post à notre formulaire 
        // et plus particulièrement à le bagage assciée 
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
                $bagage->setPicture($imageName);
            }
            // enregistrer les données
            $em = $manager->getManager();
            // il permets de mettre file d’annteds les element va ajouter en base de données
            $em->persist($bagage);
            // il permets d’excuter tous qui en attendre
            $em->flush();
            // Ajoute un messages flash pour prévenir du resultats de l'opération
            $this->addFlash("success", "Le bagage a bien été ajouté");
            return $this->redirectToRoute('app_bagages');
        }
        return $this->renderForm('bagages/save.html.twig', [
            'formBagage' => $form,
            
        ]);
    }




    
    #[Route('/bagages/{id}/update', name: 'update_bagages', requirements: ['id' => "[0-9]+"], methods: ["GET", "POST"])]
    public function update($id, ManagerRegistry $manager, Request $request): Response
    {

        //  On utirise l'utilisation d'accualiser
         if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('danger', "Vous n'avez pas le droit pour modifier un bagage");
            return $this->redirectToRoute('app_bagages');
        }



        $bagage = $manager->getRepository(Bagages::class)->find($id);

      



        if ($bagage) {

              // La modification de l'image
        /**
         *  Symfony s'attends à recevoir un fichier et non une chaine de caractère pour l'input file
         * Pour corriger cette erreur, on diot se servir du nom du fichier qui est en BDD pour charger l'image qui est stochée
         * Pour ce faire, on utilise le composant File de HttpFoundation
         */
        $oldPictureExist = true;

        if (file_exists($this->getParameter('upload_dir').'/'.$bagage->getPicture()) && !is_dir($this->getParameter('upload_dir').'/'.$bagage->getPicture())) {

            $picture = new File($this->getParameter('upload_dir').'/'.$bagage->getPicture());
            $bagage->setPicture($picture);
            $oldPictureExist =false ;

        }

        
            $form = $this->createForm(BagagesFormType::class, $bagage);
            // Associe les données provenant de $_Post à notre formulaire 
            // et plus particulièrement à le bagage assciée 
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

                        unlink($this->getParameter('upload_dir').'/'.$bagage->getPicture()->getBasename());
                    }
                    // (string) permet de préciser que l'on veut utiliser la valeur de la vaiable juste près comme une chaine de caractère
                    $bagage->setPicture((string) $imageName);
                } else {
                    // S'il y a pas de nouveau fichier, on récupère le nom du fichier déja existant pour le restocker en BDD
                    $bagage->setPicture($picture->getBasename());
                }


                $em = $manager->getManager();
                $em->persist($bagage);
                $em->flush();

                $this->addFlash("success", "Le bagage a bien été modifiée");
                return $this->redirectToRoute('app_bagages', ['id' => $bagage->getId()]);
            }
            return $this->renderForm('bagages/update.html.twig', [
                'formBagage' => $form,
                'bagage' => $bagage
            ]);
        } else {
            $this->addFlash("danger", "Le bagage démandée n'exsite pas");
            return $this->redirectToRoute('app_bagages');
        }
    }


    #[Route('/bagages/{id}/delete', name: 'delete_bagages', requirements: ['id' => "[0-9]+"], methods: ["GET"])]
    public function delete($id, ManagerRegistry $manager): Response

    {


        // On utirise l'utilisation du supprimer
        return $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $bagage = $manager->getRepository(Bagages::class)->find($id);

        if ($bagage) {
            // dd(file_exists(__DIR__.'/../../public/img/upload/'. $bagage->getPicture()));
            $em = $manager->getManager();
            $em->remove($bagage);
            $em->flush();
            $this->addFlash("success", "Le bagage a été supprimée");
        } else {

            $this->addFlash("danger", "Le bagage démandée n'exsite pas");
        }
        return $this->redirectToRoute('app_bagages');
    }



}
