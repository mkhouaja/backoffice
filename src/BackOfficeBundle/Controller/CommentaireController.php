<?php

namespace BackOfficeBundle\Controller;

use BackOfficeBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Commentaire controller.
 *
 */
class CommentaireController extends Controller
{
    /**
     * @Route("/commentaires", name="commentaires")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('BackOfficeBundle:Commentaire');
        $query = $repository->createQueryBuilder('u')
        ->select('g.email, f.nom,u.texte,u.id_com,u.date_ajout')
                ->innerjoin('BackOfficeBundle:Utilisateur', 'g' ,'WITH', 'u.id_utilisateur = g.id_utilisateur')
                ->innerjoin('BackOfficeBundle:Fiche', 'f')
                ->where ('u.id_fiche = f.id_fiche')
                ->getQuery()->getResult();


        return $this->render('BackOfficeBundle:Commentaires:commentaires.html.twig', array(
            'commentaires' => $query,
        ));
    }

     /**
    * @Route("/commentaire/add")
    */
    public function newAction(Request $request)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm('BackOfficeBundle\Form\CommentaireType', $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('commentaires');
        }

        return $this->render('commentaire/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
    }


    /**
    * @Route("/commentaire/modifier/{commentaire}", name="modifier_commentaire")
    */
    public function editAction(Request $request, Commentaire $commentaire)
    {
       
        $editForm = $this->createForm('BackOfficeBundle\Form\CommentaireType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $date = date('Y-m-d');
            $date = new \DateTime($date); 
            $commentaire>setDateModification($date);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaires');
        }

        return $this->render('BackOfficeBundle:Commentaires:modifier-commentaire.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
    * @Route("/commentaire/supprimer/{commentaire}", name="supprimer_commentaire")
    */
    public function deleteAction(Request $request, Commentaire $commentaire)
    {
         if ($commentaire) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
        }

        return $this->redirectToRoute('commentaires');
    }
    
    /*********** Liste des fonctions appelées par l'application*************/
    
    /**
     * @Route("/api/commentaires/{fiche}", name="commentaires_fiche")
     * @Method({"GET"})
     */
    public function getCommentaires(Int $fiche)
    {
      $em = $this->getDoctrine()->getManager();
       $repository = $em->getRepository('BackOfficeBundle:Commentaire');
        $query = $repository->createQueryBuilder('u')
        ->select('u.texte,u.date_ajout')         
                ->where ('u.id_fiche = :idFiche')
                ->setParameters(['idFiche'=> $fiche])
                ->getQuery()->getResult();
        $commentaires = $query;
        /* @var $fiches Fiche[] */

        $formatted = [];
        foreach ($commentaires as $commentaire) {
            
            $date = $commentaire['date_ajout']->format('d/m/Y');
            $formatted[] = [
               'date'           => $date,
               'commentaire'    => $commentaire['texte']
            ];
        }

        return new JsonResponse($formatted);
    }
}
