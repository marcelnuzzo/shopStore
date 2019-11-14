<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Utilisateur;
use Doctrine\Common\Persistence\ObjectManager;


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
    public function formulaire(Request $request, ObjectManager $manager)
    {
        $utilisateur = new Utilisateur();

        $form = $this->createFormBuilder($utilisateur)
                     ->add('nom')
                     ->add('prenom')
                     ->add('date_de_naissance')
                     ->add('mail')
                     ->add('login')
                     ->add('mot_de_passe')
                     ->add('date_de_location')
                     ->add('duree')
                     ->add('fin_de_location')
                     ->getForm();
                     
           
            $form->handleRequest($request);
            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('contact');

        return $this->render('formulaire/create.html.twig', [
            'controller_name' => 'FormulaireController',
        ]);
    }
}
