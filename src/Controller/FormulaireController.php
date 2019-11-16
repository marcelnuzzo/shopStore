<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FormulaireController extends AbstractController
{
    
    /**
     * @Route("/formulaire", name="formulaire")
     */
    public function index(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        
        //$utilisateurs = $repo->findAll();
        //$repo->findAll()

        return $this->render('formulaire/index.html.twig', [
            'controller_name' => 'FormulaireController',
        ]);
    }

    
    /**
    * @Route("/formulaire/new", name="formulaire_create")
    * @Route("/formulaire/{id}/editUti", name="formulaire_editUti")
    */
    public function formulaire(Request $request, ObjectManager $manager, Utilisateur $utilisateur = null)
    {
        if(!$utilisateur) {
            $utilisateur = new Utilisateur();
        }

        $form = $this->createFormBuilder($utilisateur)
                     ->add('prenom')
                     ->add('nom')
                     ->add('date_de_naissance')
                     ->add('mail')
                     ->add('login')
                     ->add('mot_de_passe')
                     ->add('date_de_location')
                     ->add('duree')
                     ->add('fin_de_location')

                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($utilisateur);
                    $manager->flush();
            
                        return $this->redirectToRoute('uti');
                }

            return $this->render('formulaire/create.html.twig', [
                'formUtilisateur' => $form->createView(),
                'editMode' => $utilisateur->getId() !== null
                ]);
      
    }
    

   /**
    * @Route("/formulaire/newCat", name="formulaire_createCat")
    * @Route("/formulaire/{id}/editCat", name="formulaire_editCat")
    */
    
    public function formulaireCat(Request $request, ObjectManager $manager, Category $category = null)
    {
        if(!$category) {
            $category = new Category();
        }
    
        $form = $this->createFormBuilder($category)
                     ->add('title')
                     ->add('content')
                     ->add('description')
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($category);
                    $manager->flush();
            
                        return $this->redirectToRoute('cat');
                }

                return $this->render('formulaire/createCat.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
    * @Route("/formulaire/newCom", name="formulaire_createCom")
    * @Route("/formulaire/{id}/editCom", name="formulaire_editCom")
    */
    public function formulaireCom(Article $article = null, Request $request, ObjectManager $manager, Commentaire $commentaire = null)
    {
        if(!$commentaire) {
            $commentaire = new Commentaire();
            $article = new Article();
        }
    
        $form = $this->createFormBuilder($commentaire)
                     ->add('author')
                     ->add('content')
                     ->add('createdAt', DateType::class)
                     ->add('article', EntityType::class, [
                        'class' => Article::class,
                        "choice_label" => 'title'
                    ])
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($commentaire);
                    $manager->flush();
            
                        return $this->redirectToRoute('comment');
                }

                return $this->render('formulaire/createCom.html.twig', [
                     'formCommentaire' => $form->createView(),
                     'editMode' => $commentaire->getId() !== null
                     ]);
    
    }
    
}
