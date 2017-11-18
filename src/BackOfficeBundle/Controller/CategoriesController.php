<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriesController extends Controller 
{
    /**
     * @Route("/categories", name="categories")
     */
    public function categoriessAction()
    {
        return $this->render('BackOfficeBundle:Pages:categories.html.twig');
    }
    /**
     * @Route("/categories/ajouter")
     */
    public function ajouterCategoriesAction()
    {
        return $this->render('BackOfficeBundle:Pages:ajouter-categorie.html.twig');
    }
    /**
     * @Route("/categories/modifier/{slug}")
     */
    public function modifierCategoriesAction($slug)
    {
        return $this->render('BackOfficeBundle:Pages:modifier-categorie.html.twig');
    }
}