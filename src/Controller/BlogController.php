<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Repository\ArticleRepository;

use Knp\Component\Pager\PaginatorInterface;

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
             5 /*limit per page*/
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
    public function form(Article $article = null,Request $request, ObjectManager $manager)
    {
        if(!$article) {
            $article = new Article();
        }
       
        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
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
}
