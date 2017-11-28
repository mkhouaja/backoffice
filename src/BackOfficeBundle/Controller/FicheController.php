<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Fiche;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Fiche controller.
 *
 */
class FicheController extends Controller
{
    /**
     * @Route("/fiches", name="fiches")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('BackOfficeBundle:Fiche');
        $query = $repository->createQueryBuilder('u')
        ->select('g.prenom', 'u.nom','u.decription','u.id_fiche','u.date_ajout')
                ->innerJoin('BackOfficeBundle:Administrateur', 'g')
                ->where('g.id = u.id')
                ->getQuery()->getResult();
        return $this->render('BackOfficeBundle:Fiches:fiches.html.twig', array(
            'fiches' => $query,
        ));
    }

    /**
     * @Route("/fiche/ajout")
    */
    public function newAction(Request $request)
    {
        $fiche = new Fiche();
        $form = $this->createForm('BackOfficeBundle\Form\FicheType', $fiche);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('BackOfficeBundle:Administrateur')->find("1");
        $categories = $em->getRepository('BackOfficeBundle:Categorie')->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) {
            //Enregitrer Dates et infos utilisateur
            $date = date('Y-m-d');
            $date = new \DateTime($date);
            $fiche->setDateAjout($date);
            $fiche->setDateModification($date);
            $fiche->setDateModification($date);
            $fiche->setId($user);
            //Enregistrer Categorie
            $id_cat = $request->request->get('categorie');
            $categorie = $this->getDoctrine()->getRepository('BackOfficeBundle:Categorie')->find($id_cat);
            $fiche->setIdCat($categorie);  
            //var_dump ($categorie);   
            var_dump($request->request->get('image'));
            $em->persist($fiche);
            $em->flush();

            return $this->redirectToRoute('fiche_show', array('id_fiche' => $fiche->getId_fiche()));
        }

        return $this->render('BackOfficeBundle:Fiches:ajouter-fiche.html.twig', array(
            'fiche' => $fiche,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

 

    /**
    * @Route("/fiche/modifier/{fiche}", name="modifier_fiche")
    */
    public function editAction(Request $request, Fiche $fiche)
    {
        $deleteForm = $this->createDeleteForm($fiche);
        $editForm = $this->createForm('BackOfficeBundle\Form\FicheType', $fiche);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiche_edit', array('id_fiche' => $fiche->getId_fiche()));
        }

        return $this->render('fiche/edit.html.twig', array(
            'fiche' => $fiche,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fiche entity.
     *
     */
    public function deleteAction(Request $request, Fiche $fiche)
    {
        $form = $this->createDeleteForm($fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fiche);
            $em->flush();
        }

        return $this->redirectToRoute('fiche_index');
    }

    /**
     * Creates a form to delete a fiche entity.
     *
     * @param Fiche $fiche The fiche entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fiche $fiche)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fiche_delete', array('id_fiche' => $fiche->getId_fiche())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
