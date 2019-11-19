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
     * 
    * @Route("/admin/Cat/new", name="admin_createCat")
    * @Route("/admin/{id}/editCat", name="admin_editCat_admin")
    */
    public function editCat(Request $request, ObjectManager $manager, Category $category = null)
    {
        if(!$category) {
            $category = new Category();
        }
    
        $form = $this->createFormBuilder($category)
                     ->add('title')
                     ->add('content')
                     ->add('description')
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    
                    $manager->persist($category);
                    $manager->flush();
            
                        return $this->redirectToRoute('cat');
                }

                return $this->render('admin/editCat_adminy.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
     * @Route("/index_article", name="index_article")
     *  @Route("/admin/{id}/editArt", name="admin_editArt")
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