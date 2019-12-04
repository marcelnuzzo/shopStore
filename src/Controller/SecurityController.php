<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
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
     * @Route("formUser", name="formUser")
     */
    public function formUser()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('security/formUser.html.twig', [
            'controller_name' => 'SecurityController',
            'articles' => $articles
        ]);
    }
}
