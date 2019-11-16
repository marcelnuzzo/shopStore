<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        
        $repo = $this->getDoctrine()->getRepository(Article::class);
        
        $articles = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
             15 /*limit per page*/
        );

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
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Category $category = null, Request $request, ObjectManager $manager)
    {
        if(!$article) {
            $article = new Article();
            $category = new Category();
        }
       
        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->add('category', EntityType::class, [
                        'class' => Category::class,
                        "choice_label" => 'title'
                    ])
                     ->getForm();

        
            $form->handleRequest($request);
       
        
        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            //$manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()
            ]);
        }

        return $this->render("blog/create.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        return $this->render('blog/show.html.twig', [
            'article'=> $article
        ]);
    }

    /**
     * @Route("/cat", name="cat")
     */
    public function cat()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repo->findAll();

        return $this->render('blog/cat.html.twig', [
            'controller_name' => 'BlogController',
            'categories'=> $categories
        ]);
    }

    /**
     * @Route("/comment", name="comment")
     */
    public function comment()
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);

        $commentaires = $repo->findAll();

        return $this->render('blog/comment.html.twig', [
            'controller_name' => 'BlogController',
            'commentaires'=> $commentaires
        ]);
    }

    /**
     * @Route("/uti", name="uti")
     */
    public function uti()
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);

        $utilisateur = $repo->findAll();

        return $this->render('blog/uti.html.twig', [
            'controller_name' => 'BlogController',
            'utilisateurs'=> $utilisateur
        ]);
    }
}
