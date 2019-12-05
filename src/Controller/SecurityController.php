<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="index_index")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'articles' => $articles
        ]);
    }

   
    /**
    * @Route("security/formUser", name="security_formUser")
    * 
    */
    public function formUser(Request $request, EntityManagerInterface $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        
            $user = new User();
        

        $form = $this->createFormBuilder($user)
                     ->add('name')
                     ->add('mail')
                     ->add('login')
                     ->add('mot_de_passe', PasswordType::class)
                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($user);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_utilisateur');
                }

        return $this->render('security/formUser.html.twig', [
            'controller_name' => 'SecurityController',
            'articles' => $articles,
            'formUser' => $form->createView()
        ]);
    }
}
