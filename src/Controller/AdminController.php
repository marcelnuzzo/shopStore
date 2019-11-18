<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="edit_admin")
     */
    public function index()
    {
        return $this->render('admin/edit_admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/", name="categorie")
     */
    public function categorie()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repo->findAll();

        return $this->render('admin/categorie.html.twig', [
            'controller_name' => 'AdminController',
            'categories'=> $categories
        ]);
    }
}
