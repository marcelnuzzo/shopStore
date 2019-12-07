<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/** @Route("Security") */
class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="index_index")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'articles' => $articles,
        ]);
    }

    /** @Route("/Inscription", name="security_formUser", methods={"GET", "POST"}) */
    public function formUser(Request $request, UserPasswordEncoderInterface $encoder)
    {   
        $em = $this->getDoctrine()->getManager();
        $articles = ($em->getRepository(Article::class))->findAll();
        $user = new User($em);
        $form = $this->get('form.factory')->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $request->isMethod('POST')) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre compte à bien été enregistré.');

            return $this->redirectToRoute('security_login');
        }

        $twigConfig['formUser'] = $form->createView();
        $twigConfig['user'] = $user;
        $twigConfig['articles'] = $articles;

        return $this->render('security/formUser.html.twig', $twigConfig);
    }

    /**
     * @Route("/Connexion", name="security_login")
     */
    public function login()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('security/login.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/Deconnexion", name="security_logout")
     */
    public function logout()
    {
    }
}
