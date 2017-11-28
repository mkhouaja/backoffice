<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Administrateur controller.
 *
 */
class AdministrateurController extends Controller
{
    /**
     * Lists all administrateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $administrateurs = $em->getRepository('BackOfficeBundle:Administrateur')->findAll();

        return $this->render('administrateur/index.html.twig', array(
            'administrateurs' => $administrateurs,
        ));
    }

    /**
     * Creates a new administrateur entity.
     *
     */
    public function newAction(Request $request)
    {
        $administrateur = new Administrateur();
        $form = $this->createForm('BackOfficeBundle\Form\AdministrateurType', $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($administrateur);
            $em->flush();

            return $this->redirectToRoute('administrateur_show', array('id' => $administrateur->getId()));
        }

        return $this->render('administrateur/new.html.twig', array(
            'administrateur' => $administrateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a administrateur entity.
     *
     */
    public function showAction(Administrateur $administrateur)
    {
        $deleteForm = $this->createDeleteForm($administrateur);

        return $this->render('administrateur/show.html.twig', array(
            'administrateur' => $administrateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing administrateur entity.
     *
     */
    public function editAction(Request $request, Administrateur $administrateur)
    {
        $deleteForm = $this->createDeleteForm($administrateur);
        $editForm = $this->createForm('BackOfficeBundle\Form\AdministrateurType', $administrateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrateur_edit', array('id' => $administrateur->getId()));
        }

        return $this->render('administrateur/edit.html.twig', array(
            'administrateur' => $administrateur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a administrateur entity.
     *
     */
    public function deleteAction(Request $request, Administrateur $administrateur)
    {
        $form = $this->createDeleteForm($administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($administrateur);
            $em->flush();
        }

        return $this->redirectToRoute('administrateur_index');
    }

    /**
     * Creates a form to delete a administrateur entity.
     *
     * @param Administrateur $administrateur The administrateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Administrateur $administrateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administrateur_delete', array('id' => $administrateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
