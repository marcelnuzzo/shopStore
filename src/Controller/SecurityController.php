<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function formUser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        
            $user = new User();
        
        $form = $this->createFormBuilder($user)
                     ->add('username')
                     ->add('mail')
                     ->add('login')
                     ->add('password', PasswordType::class)
                     ->add('confirm_password', PasswordType::class)
                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    $hash = $encoder->encodePassword($user, $user->getPassword());

                    $user->setPassword($hash);
                    
                    $manager->persist($user);
                    $manager->flush();
            
                        return $this->redirectToRoute('security_login');
                }

        return $this->render('security/formUser.html.twig', [
            'controller_name' => 'SecurityController',
            'articles' => $articles,
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('security/login.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}
    
}
