<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="index_admin")
     */
    public function index()
    {
        return $this->render('admin/index_admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/index_categorie", name="index_categorie")
     *  @Route("/admin/{id}/editCat", name="admin_editCat")
     */
    public function categorie()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        
        $categories = $repo->findAll();
       
        return $this->render('admin/index_categorie.html.twig', [
            'controller_name' => 'AdminController',
            'categories'=> $categories
        ]);
    }


     /**
     * @Route("/admin/editArt", name="admin_editArt")
     * 
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

            return $this->redirectToRoute('index_article', ['id' => $article->getId()
            ]);
        }

        return $this->render("admin/editArt.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

     /**
     * 
     * @Route("/admin/editArt/{id}", name="admin/editArt")
     */
    public function form2(Article $article = null, Category $category = null, Request $request, ObjectManager $manager)
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

            return $this->redirectToRoute('index_article', ['id' => $article->getId()
            ]);
        }

        return $this->render("admin/editArt.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/index_article", name="index_article")
     *  
     */
    public function article()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        
        return $this->render('admin/index_article.html.twig', [
            'controller_name' => 'AdminController',
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/index_commentaire", name="index_commentaire")
     *  @Route("/admin/{id}/editCom", name="admin_editCom")
     */
    public function commentaire()
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $repo->findAll();
        
        return $this->render('admin/index_commentaire.html.twig', [
            'controller_name' => 'AdminController',
            'commentaires'=> $commentaires
        ]);
    }

    /**
     * @Route("/index_utilisateur", name="index_utilisateur")
     *  @Route("/admin/{id}/editUti", name="admin_editUti")
     */
    public function utilisateur()
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();
        
        return $this->render('admin/index_utilisateur.html.twig', [
            'controller_name' => 'AdminController',
            'utilisateurs'=> $utilisateurs
        ]);
    }

}