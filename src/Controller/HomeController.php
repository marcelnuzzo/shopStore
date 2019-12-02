<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        $articles = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
             15 /*limit per page*/
        );
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/base", name="base")
     *  
     */
    public function article()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        
        return $this->render('home/base.html.twig', [
            'controller_name' => 'AdminController',
            'articles'=> $articles
        ]);
    }

    /**
    * @route("/apropos", name="apropos")
    */
    public function apropos()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $repo1 = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        $article = $repo1->findAll();

        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController',
            'articles'=>$articles,
            'article'=>$article
        ]);
    }

    /**
    *  @Route("/contact", name="contact")
    */
    public function contact()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $repo1 = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        $article = $repo1->findAll();

        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'articles'=>$articles,
            'article'=> $article
        ]);
    }

    /**
     *  @Route("/admin/admin", name="admin")
    */
    public function admin()
    {
        return $this->render('home/admin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home/recherche", name="recherche")
     */
    /*
    public function recherche($id, ObjectManager $manager, Request $request)
    {
        $recherche = new Recherche();
        $form = $this->createFormBuilder($recherche)
                     ->add('categieArticle')
                     ->getForm();

                     $form->handleRequest($request);

                     if($form->isSubmitted() && $form->isValid()) {
                        
                        $manager->persist($recherche);
                        $manager->flush();
                
                            return $this->redirectToRoute('home_recherche',  ['id' => $article->getId()
                            ]);
                    }
        return $this->render('home/recherche.html.twig', [
            'controller_name' => 'HomeController',
        ]);

    }
    */
}
