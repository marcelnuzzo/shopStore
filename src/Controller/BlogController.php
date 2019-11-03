<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

     /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $article = new Article();
       
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, [
                         'attr'=> [
                             'placeholder' => "titre de l'article"
                         ]
                     ])
                     ->add('content', TextareaType::class, [
                         'attr' => [
                             'placeholder' => "contenu de l'article"
                         ]
                     ])
                     ->add('image', TextType::class, [
                         'attr' => [
                            'placeholder' => "image de l'article"
                         ]
                     ])
                     ->getForm();

        return $this->render("blog/create.html.twig", [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);

        return $this->render('blog/show.html.twig', [
            'article'=> $article
        ]);
    }

}
