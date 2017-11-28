<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * @Route("/utilisateurs", name="utilisateurs")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('BackOfficeBundle:Utilisateur')->findAll();

        return $this->render('BackOfficeBundle:Utilisateurs:utilisateurs.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }
    /**
    * @Route("/utilisateur/modifier/{utilisateur}", name="modifier_utilisateur")
    */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $editForm = $this->createForm('BackOfficeBundle\Form\UtilisateurType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('BackOfficeBundle:Utilisateurs:modifier-utilisateur.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView()
        ));
    }

     /**
    * @Route("/utilisateur/supprimer/{utilisateur}", name="supprimer_utilisateur")
    */
    public function deleteAction(Utilisateur $utilisateur)
    {

        if ($utilisateur) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('utilisateurs');
    }
}
