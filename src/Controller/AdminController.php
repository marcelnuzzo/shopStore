<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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

    /**
    * @Route("/admin/newCat", name="admin_createCat")
    * 
    */
    public function formulaireCat(Request $request, ObjectManager $manager, Category $category = null)
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
                    if(!$category)
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($category);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_categorie');
                }

                return $this->render('admin/createCat.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
    * 
    * @Route("/admin/editionCat/{id}", name="admin_editCat")
    */
    public function formulaireCat2(Request $request, ObjectManager $manager, Category $category = null)
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
                    if(!$category)
                        $editMode = 0;
                    else
                        $editMode = 0;
                    $manager->persist($category);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_categorie',  ['id' => $category->getId()
                        ]);
                }

                return $this->render('admin/createCat.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
    * @Route("/admin/newCom", name="admin_createCom")
    * 
    */
    public function formulaireCom(Article $article = null, Request $request, ObjectManager $manager, Commentaire $commentaire = null)
    {
        if(!$commentaire) {
            $commentaire = new Commentaire();
            $article = new Article();
        }
    
        $form = $this->createFormBuilder($commentaire)
                     ->add('author')
                     ->add('content')
                     ->add('createdAt', DateType::class)
                     ->add('article', EntityType::class, [
                        'class' => Article::class,
                        "choice_label" => 'title'
                    ])
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    if(!$commentaire)
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($commentaire);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_commentaire');
                }

                return $this->render('admin/createCom.html.twig', [
                     'formCommentaire' => $form->createView(),
                     'editMode' => $commentaire->getId() !== null
                     ]);
    
    }

    /**
    * 
    * @Route("/admin/editionCom/{id}", name="admin_editCom")
    */
    public function formulaireCom1(Article $article = null, Request $request, ObjectManager $manager, Commentaire $commentaire = null)
    {    
        $form = $this->createFormBuilder($commentaire)
                     ->add('author')
                     ->add('content')
                     ->add('createdAt', DateType::class)
                     ->add('article', EntityType::class, [
                        'class' => Article::class,
                        "choice_label" => 'title'
                    ])
                     ->getForm();

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    if(!$commentaire)
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($commentaire);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_commentaire',  ['id' => $commentaire->getId()
                        ]);
                }

                return $this->render('admin/createCom.html.twig', [
                     'formCommentaire' => $form->createView(),
                     'editMode' => $commentaire->getId() !== null
                     ]);
    
    }


    /**
    * @Route("/admin/newUti", name="admin_createUti")
    * 
    */
    public function formulaireUti(Request $request, ObjectManager $manager, Utilisateur $utilisateur = null)
    {
        if(!$utilisateur) {
            $utilisateur = new Utilisateur();
        }

        $form = $this->createFormBuilder($utilisateur)
                     ->add('prenom')
                     ->add('nom')
                     ->add('date_de_naissance')
                     ->add('mail')
                     ->add('login')
                     ->add('mot_de_passe', PasswordType::class)
                     ->add('date_de_location')
                     ->add('duree')
                     ->add('fin_de_location')

                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    if(!$utilisateur)
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($utilisateur);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_utilisateur');
                }

            return $this->render('admin/createUti.html.twig', [
                'formUtilisateur' => $form->createView(),
                'editMode' => $utilisateur->getId() !== null
                ]);
      
    }

    /**
    * 
    * @Route("/admin/editionUti/{id}", name="admin_editUti")
    */
    public function formulaireUti1(Request $request, ObjectManager $manager, Utilisateur $utilisateur = null)
    {
        if(!$utilisateur) {
            $utilisateur = new Utilisateur();
        }

        $form = $this->createFormBuilder($utilisateur)
                     ->add('prenom')
                     ->add('nom')
                     ->add('date_de_naissance')
                     ->add('mail')
                     ->add('login')
                     ->add('mot_de_passe', PasswordType::class)
                     ->add('date_de_location')
                     ->add('duree')
                     ->add('fin_de_location')

                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    if(!$utilisateur->getId()) 
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($utilisateur);
                    $manager->flush();
            
                        return $this->redirectToRoute('index_utilisateur',  ['id' => $utilisateur->getId()
                        ]);
                }

            return $this->render('admin/createUti.html.twig', [
                'formUtilisateur' => $form->createView(),
                'editMode' => $utilisateur->getId() !== null
                ]);
      
    }

     /**
     * @Route("/admin/newArt", name="admin_createArt")
     * 
     */
    public function formArt(Article $article = null, Category $category = null, Request $request, ObjectManager $manager)
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
                $editMode = 0;
            }
            else {
                $editMode = 1;
            }
            $manager->persist($article);
           
            $manager->flush();
            $this->addFlash('success', 'Article créé');

            return $this->redirectToRoute('index_article');
        }

    return $this->render("admin/createArt.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

     /**
     * 
     * @Route("/admin/editionArt/{id}", name="admin_editArt")
     */
    public function formArtarticle1 (Article $article = null, Category $category = null, Request $request, ObjectManager $manager)
    {
       
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
                $editMode = 0;
            }
            else {
                $editMode = 1;
            }
            $manager->persist($article);
           
            $manager->flush();

            return $this->redirectToRoute('index_article', ['id' => $article->getId()
            ]);
        }

    return $this->render("admin/createArt.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/index_article/{id}/deleteArt", name="admin_deleteArt")
     */
    public function deleteArt($id, ObjectManager $Manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        $Manager->remove($article);
        $Manager->flush();
        
        return $this->redirectToRoute('index_article');
       
    }

    /**
     * @Route("/admin/index_categorie/{id}/deleteCat", name="admin_deleteCat")
     */
    public function deleteCat($id, ObjectManager $Manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $category = $repo->find($id);
       
        $Manager->remove($category);
        $Manager->flush();
        
        return $this->redirectToRoute('index_categorie');
       
    }

    /**
     * @Route("/admin/index_commentaire/{id}/deleteCom", name="admin_deleteCom")
     */
    public function deleteCom($id, ObjectManager $Manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $comment = $repo->find($id);
        $Manager->remove($comment);
        $Manager->flush();
        
        return $this->redirectToRoute('index_commentaire');
       
    }

    /**
     * @Route("/admin/index_utilisateur/{id}/deleteUti", name="admin_deleteUti")
     */
    public function deleteUti($id, ObjectManager $Manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repo->find($id);
        $Manager->remove($utilisateur);
        $Manager->flush();
        
        return $this->redirectToRoute('index_utilisateur');
       
    }

}

