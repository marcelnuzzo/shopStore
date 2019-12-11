<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;



class AdminController extends AbstractController
{
    /**
    * @Route("/admin", name="admin_index")
    */
    public function index()
    {
        return $this->render('admin/admin_index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * @Route("/admin_categorie", name="admin_categorie")
     */
    public function categorie(PaginatorInterface $paginator, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        
        $categories = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
       
        return $this->render('admin/admin_categorie.html.twig', [
            'controller_name' => 'AdminController',
            'categories'=> $categories
        ]);
    }

     /**
     * @Route("/admin_article", name="admin_article")
     */
    public function article(PaginatorInterface $paginator, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
             15 /*limit per page*/
        );
        
        return $this->render('admin/admin_article.html.twig', [
            'controller_name' => 'AdminController',
            'articles'=> $articles
        ]);
    }

    /**
     * @Route("/admin_commentaire", name="admin_commentaire")
     */
    public function commentaire(PaginatorInterface $paginator, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaires = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
             15 /*limit per page*/
        );
        
        return $this->render('admin/admin_commentaire.html.twig', [
            'controller_name' => 'AdminController',
            'commentaires'=> $commentaires
        ]);
    }

    /**
     * @Route("/admin_utilisateur", name="admin_utilisateur")
     */
    public function utilisateur()
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateurs = $repo->findAll();
        
        return $this->render('admin/admin_utilisateur.html.twig', [
            'controller_name' => 'AdminController',
            'utilisateurs'=> $utilisateurs
        ]);
    }

     /**
     * @Route("/admin_user", name="admin_user")
     */
    public function user()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        
        return $this->render('admin/admin_user.html.twig', [
            'controller_name' => 'AdminController',
            'users'=> $users
        ]);
    }

    /**
    * @Route("/admin/newCat", name="admin_createCat")
    */
    public function formulaireCat(Request $request, EntityManagerInterface $manager, Category $category = null)
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
            
                        return $this->redirectToRoute('admin_categorie');
                }

                return $this->render('admin/createCat.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
    * @Route("/admin/editionCat/{id}", name="admin_editCat")
    */
    public function formulaireCat2(Request $request, EntityManagerInterface $manager, Category $category = null)
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
            
                        return $this->redirectToRoute('admin_categorie',  ['id' => $category->getId()
                        ]);
                }

                return $this->render('admin/createCat.html.twig', [
                     'formCategory' => $form->createView(),
                     'editMode' => $category->getId() !== null
                     ]);
    
    }

    /**
    * @Route("/admin/newCom", name="admin_createCom")
    */
    public function formulaireCom(Article $article = null, Request $request, EntityManagerInterface $manager, Commentaire $commentaire = null)
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
            
                        return $this->redirectToRoute('admin_commentaire');
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
    public function formulaireCom1(Article $article = null, Request $request, EntityManagerInterface $manager, Commentaire $commentaire = null)
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
            
                        return $this->redirectToRoute('admin_commentaire',  ['id' => $commentaire->getId()
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
    public function formulaireUti(Request $request, EntityManagerInterface $manager, Utilisateur $utilisateur = null)
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
            
                        return $this->redirectToRoute('admin_utilisateur');
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
    public function formulaireUti1(Request $request, EntityManagerInterface $manager, Utilisateur $utilisateur = null)
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
            
                        return $this->redirectToRoute('admin_utilisateur',  ['id' => $utilisateur->getId()
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
    public function formArt(Article $article = null, Category $category = null, Request $request, EntityManagerInterface $manager)
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

            return $this->redirectToRoute('admin_article');
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
    public function formArtarticle1 (Article $article = null, Category $category = null, Request $request, EntityManagerInterface $manager)
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

            return $this->redirectToRoute('admin_article', ['id' => $article->getId()
            ]);
        }

    return $this->render("admin/createArt.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
    * @Route("/admin/newUser", name="admin_createUser")
    * 
    */
    public function formulaireUser(UserPasswordEncoderInterface $encoder,Request $request, EntityManagerInterface $manager, User $user = null)
    {
        if(!$user) {
            $user = new User();
        }

        $form = $this->createFormBuilder($user)
                     ->add('username')
                     ->add('mail')
                     ->add('password', PasswordType::class)
                     ->add('confirm_password', PasswordType::class)
                     ->getForm();
                     
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    $hash = $encoder->encodePassword($user, $user->getPassword());

                    $user->setPassword($hash);
                    if(!$user)
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($user);
                    $manager->flush();
            
                        return $this->redirectToRoute('admin_user');
                }

            return $this->render('admin/createUser.html.twig', [
                'formUser' => $form->createView(),
                'editMode' => $user->getId() !== null
                ]);
      
    }

    /**
    * 
    * @Route("/admin/editionUser/{id}", name="admin_editUser")
    */
    public function formulaireUser1(UserPasswordEncoderInterface $encoder, Request $request, EntityManagerInterface $manager, User $user = null)
    {
        if(!$user) {
            $user = new User();
        }

        $form = $this->createFormBuilder($user)
                    ->add('username')
                    ->add('mail')
                    ->add('password', PasswordType::class)
                    ->add('confirm_password', PasswordType::class)
                    ->getForm();               
           
                $form->handleRequest($request);
               
                if($form->isSubmitted() && $form->isValid()) {
                    $hash = $encoder->encodePassword($user, $user->getPassword());

                    $user->setPassword($hash);
                    if(!$user->getId()) 
                        $editMode = 0;
                    else
                        $editMode = 1;
                    $manager->persist($user);
                    $manager->flush();
            
                        return $this->redirectToRoute('admin_user',  ['id' => $user->getId()
                        ]);
                }

            return $this->render('admin/createUser.html.twig', [
                'formUser' => $form->createView(),
                'editMode' => $user->getId() !== null
                ]);
      
    }

    /**
     * @Route("/admin/admin_article/{id}/deleteArt", name="admin_deleteArt")
     */
    public function deleteArt($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);

        $Manager->remove($article);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_article');
       
    }

    /**
     * @Route("/admin/admin_categorie/{id}/deleteCat", name="admin_deleteCat")
     */
    public function deleteCat($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $category = $repo->find($id);
       
        $Manager->remove($category);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_categorie');
       
    }

    /**
     * @Route("/admin/admin_commentaire/{id}/deleteCom", name="admin_deleteCom")
     */
    public function deleteCom($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class);
        $comment = $repo->find($id);
        $Manager->remove($comment);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_commentaire');
       
    }

    /**
     * @Route("/admin/admin_utilisateur/{id}/deleteUti", name="admin_deleteUti")
     */
    public function deleteUti($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repo->find($id);
        $Manager->remove($utilisateur);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_utilisateur');
       
    }

    /**
     * @Route("/admin/admin_user/{id}/deleteUser", name="admin_deleteUser")
     */
    public function deleteUser($id, EntityManagerInterface $Manager)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);
        $Manager->remove($user);
        $Manager->flush();
        
        return $this->redirectToRoute('admin_user');
       
    }

}

