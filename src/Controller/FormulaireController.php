<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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
    */
    /*
    public function formulaire(Request $request, ObjectManager $manager)
    {
        $utilisateur = new Utilisateur();

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
                     
           
            
                     //$form->handleRequest($request);
                //CreateView();
                $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('contact');

            return $this->render('formulaire/create.html.twig', [
                'formUtilisateur' => $form->createView()]);
        
      
    }
    */

   /**
    * @Route("/formulaire/new", name="formulaire_create")
    * @Route("/formulaire/{id}/edit", name="formulaire_edit")
    */
    public function form(Request $request, ObjectManager $manager, Category $category = null)
    {
        if(!$category) {
            $category = new Category();
        }
    
        $form = $this->createFormBuilder($category)
                     ->add('content')
                     ->add('description')
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($category);
                    $manager->flush();
            
                        return $this->redirectToRoute('contact');
                }

                return $this->render('formulaire/create.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }
}
