<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Product;
use App\Form\FiltreFormType;
use App\Form\ProductFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {
        $product = $manager->getRepository(Product::class)->findAll();
        // Section de searche
        $filteredPosts = array();
     
        $form = $this->createForm(FiltreFormType::class);   
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $searchWord = $form->get('searchword')->getData();
            $minPrix = $form->get('minprice')->getData();
            $maxPrix = $form->get('maxprice')->getData();
            $filteredPosts = $manager->getRepository(Article::class)->findWithSearchword($searchWord, $minPrix, $maxPrix);
        }
        return $this->renderForm('product/index.html.twig', [
            'products' => $product,
            'form' => $form,
            'filteredPosts' => $filteredPosts
        ]); 
    }





    #[Route('/product/{id}', name: 'single_product', requirements: ['id' => '[0-9]+'])]
    public function single($id, ManagerRegistry $manager): Response
    {
        // charge un produit en function de i'id reçu
        $product = $manager->getRepository(Product::class)->find($id);
        // si on trouve le produit, on affiche la page 
        if ($product) {
            return $this->render('product/single.html.twig', [
                'product' => $product
            ]);
        } else {
            $this->addFlash("danger", "Le droduit démandée n'exsite pas");
            // Sinon on redirect l'utilisateur vers la pag contenant touts les produits
            return $this->redirectToRoute('app_product');
        }
    }





    #[Route('/product/save', name: 'save_product', methods: ["GET", "POST"])]
    #[IsGranted(data:'ROLE_ADMIN', message: "Vous n'avez pas les autorisations nécessaire", statusCode: 403)]
    public function save(Request $request, ManagerRegistry $manager): Response
    {
        // On créé un nouveau produit

        $product = new Product;
        // ON créé le formulaire auquel on associe le produit qui récupérationles information
        $form = $this->createFormBuilder($product)
            // On ajoute l'input pour le name du produit
            // Attention n'oubliez pas le: use Symfony \Component \form\Extention\core\Type\TextType
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'required' => true
            ])

            ->add('type', TextType::class, [
                'label' => 'La catégorei du produit',
                'required' => true
            ])

            ->add('original', TextType::class, [
                'label' => "L'original du produit",
                'required' => true
            ])

            ->add('price', NumberType::class, [
                'label' => "Le prix du produit",
                'required' => true
            ])

            ->add('picture', FileType::class, [
                'label' => "Image du produit",
                'mapped' => false,
                'required' => false,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                'class' => 'btn btn-primary'
                ]
            ])
            // Génère l'objet formulaire
            ->getForm();
        // Associe les données provenant de $_Post à notre formulaire 
        // et plus particulièrement à le produit assciée 
        $form->handleRequest($request);
        // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
        //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
        //pour chaque propriété
        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();
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
                $product->setPicture($imageName);
            }

            $em = $manager->getManager();
            $em->persist($product);
            $em->flush();
            // Ajoute un messages flash pour prévenir du resultats de l'opération
            $this->addFlash("success", "Le produit a bien été ajouté");
            return $this->redirectToRoute('app_product');
        }
        return $this->renderForm('product/save.html.twig', [
            'formproduct' => $form,
            'product' => $product
        ]);
    }



    #[Route('/product/{id}/update', name: 'update_product', requirements: ['id' => "[0-9]+"], methods: ["GET", "POST"])]
    public function update($id, ManagerRegistry $manager, Request $request): Response
    {
        // On utirise l'utilisation d'accualiser
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('danger', "Vous n'avez pas le droit pour modifier un product");
            return $this->redirectToRoute('app_product');
        }


        $product = $manager->getRepository(Product::class)->find($id);

      

        


        if ($product) {

              // La modification de l'image
        /**
         *  Symfony s'attends à recevoir un fichier et non une chaine de caractère pour l'input file
         * Pour corriger cette erreur, on diot se servir du nom du fichier qui est en BDD pour charger l'image qui est stochée
         * Pour ce faire, on utilise le composant File de HttpFoundation
         */
        $oldPictureExist = true;
        if (file_exists($this->getParameter('upload_dir').'/'.$product->getPicture()) && !is_dir($this->getParameter('upload_dir').'/'.$product->getPicture())) {

            $picture = new File($this->getParameter('upload_dir').'/'.$product->getPicture());
            $product->setPicture($picture);
            $oldPictureExist = false;

        }

        
            $form = $this->createForm(ProductFormType::class, $product);
            // Associe les données provenant de $_Post à notre formulaire 
            // et plus particulièrement à le produit assciée 
            $form->handleRequest($request);
             // $form->isSubmitted() vérifie que le formulaire a bien été soumis par la button pour
            //$form->isValid() vérifie que les donéés reçues correspondant à toutes les contraintes indiquées
            //pour chaque propriété
            if ($form->isSubmitted() && $form->isValid()) {



                 // La modification de l'image
                // On récupère le nouveau fichier du formulaire 

                 $uploadedPicture = $form->get('picture')->getData();

                 if($uploadedPicture) {
                    // S'il y a un nouveau fichier
                     $imageName = md5(uniqid()).'.'.$uploadedPicture->guessExtension();
                    // On déplace le nouveau fichier 
                     $uploadedPicture->move($this->getParameter('upload_dir'), $imageName);
                     // On surpprimer l'image du produit
                    // On supprime l'ancien fichier 
                    if($oldPictureExist) {

                        unlink($this->getParameter('upload_dir').'/'.$product->getPicture()->getBasename());
                    }
                     // (string) permet de préciser que l'on veut utiliser la valeur de la vaiable juste près comme une chaine de caractère
                     $product->setPicture((string) $imageName);
                 } else {
                    // S'il y a pas de nouveau fichier, on récupère le nom du fichier déja existant pour le restocker en BDD
                     $product->setPicture($picture->getBasename());
                 }




                $em = $manager->getManager();
                $em->persist($product);
                $em->flush();

                $this->addFlash("success", "Le produit a bien été modifiée");
                return $this->redirectToRoute('app_product', ['id' => $product->getId()]);
            }
            return $this->renderForm('product/update.html.twig', [
                'formproduct' => $form,
                'product' => $product
            ]);
        } else {
            $this->addFlash("danger", "Le produit démandée n'exsite pas");
            return $this->redirectToRoute('app_product');
        }
    }



    #[Route('/product/{id}/delete', name: 'delete_product', requirements: ['id' => "[0-9]+"], methods: ["GET"])]
    public function delete($id, ManagerRegistry $manager): Response

    {
        // On utirise l'utilisation du supprimer
        return $this->denyAccessUnlessGranted('ROLE_ADMIN');



        
        $product = $manager->getRepository(Product::class)->find($id);

        if ($product) {
            $em = $manager->getManager();
            $em->remove($product);
            $em->flush();
            $this->addFlash("success", "Le produit a été supprimée");
        } else {

            $this->addFlash("danger", "Le produit démandée n'exsite pas");
        }
        return $this->redirectToRoute('app_product');
    }
}
