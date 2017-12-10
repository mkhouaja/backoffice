<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * Categorie controller.
 *
 */


class CategorieController extends Controller
{
   
    /**
     * @Route("/categories", name="categories")
    */
    public function indexAction(SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find($session->get('id'));  
        $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();

        return $this->render('BackOfficeBundle:Categories:categories.html.twig', array(
            'categories' => $categories,
            'administrateur' => $user->getPrenom(),
            'error' =>''
        ));
    }
    /**
    * @Route("/categorie/ajout", name="ajout_categorie")
    */
    public function newAction(Request $request,SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        $categorie = new Categorie();
        $form = $this->createForm('BackOfficeBundle\Form\CategorieType', $categorie, array(
            'action' => $this->generateUrl('ajout_categorie'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        //var_dump($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $date = date('Y-m-d');
            $date = new \DateTime($date);
            $categorie->setDateAjout($date);
            $categorie->setDateModification($date);
           
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render('BackOfficeBundle:Categories:ajouter-categorie.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }


    /**
    * @Route("/categorie/modifier/{categorie}", name="modifier_categorie")
    */
    public function editAction(Request $request, Categorie $categorie,SessionInterface $session)
    {
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        // $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('BackOfficeBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $date = date('Y-m-d');
            $date = new \DateTime($date); 
            $categorie->setDateModification($date);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render('BackOfficeBundle:Categories:modifier-categorie.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
    * @Route("/categorie/supprimer/{categorie}", name="supprimer_categorie")
    */
    public function deleteAction(Request $request, Categorie $categorie,SessionInterface $session)
    {          
        if($session->get('id')==''){
             return $this->redirectToRoute('admin');
        }
        if ($categorie) {
            $em = $this->getDoctrine()->getManager();
            if ($em->remove($categorie))
            {
                $em->flush();
                return $this->redirectToRoute('categories');
            }
            else {
                $em = $this->getDoctrine()->getManager();
                $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find($session->get('id'));  
                $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();
                return $this->render('BackOfficeBundle:Categories:categories.html.twig', array(
                 'categories' => $categories,
                 'error'=> "Impossible de supprimer une catégorie reliées a des fiches"));
            }
        }   
    }
    /*********** Liste des fonctions appelées par l'application*************/
    /**
     * @Route("/api/categories-list", name="categories_list")
     * @Method({"GET"})
    */
    public function getCategories()
    {
       $em = $this->getDoctrine()->getManager();
       $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();
        /* @var $categories Categorie[] */

        $formatted = [];
        foreach ($categories as $categorie) {
            $formatted[] = [
               'id' => $categorie->getIdCat(),
               'nom' => $categorie->getNom(),
            ];
        }

        return new JsonResponse($formatted);
    }
    
    /**
     * @Route("/api/categorie/{categorie}", name="categorie")
     * @Method({"GET"})
    */
    public function getCategorie(Int $categorie)
    {
       $em = $this->getDoctrine()->getManager();
       $categories = $em->getRepository('BackOfficeBundle:Categorie')->find($categorie);
       return new JsonResponse($categories->getNom());
    }
}
